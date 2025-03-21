<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductImageController extends BaseController
{
    private $productModel;
    private $productImageModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
    }

    public function create($productId)
    {
        $type = $this->request->getMethod();
        if ($type == 'GET') {
            $data['productId'] = $productId;
            return view('/product/v_product_image_form', $data);
        }

        $validationRules = [
            'userfile' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[userfile,5120]', // 5MB
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be JPG, JPEG, PNG, WEBP, or GIF',
                    'max_size' => 'File size must not exceed 5MB'
                ]
            ]
        ];

        $productImage = $this->request->getFile('userfile');

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        //Save temporary data to get the id
        $tempData = [
            'product_id' => $productId,
            'image_path' => 'temp_path',
            'is_primary' => false
        ];
        $this->productImageModel->save($tempData);


        $newId = $this->productImageModel->getInsertID();
        $uploadPath = FCPATH . 'uploads/products/' . $productId . '/' . $newId . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $productName = $this->productModel->find($productId)->name;
        $imageName = $productId . '_' . $productName . '_' . $newId . '.' . $productImage->getClientExtension();
        $filePath = $uploadPath . 'original_' . $imageName;
        $productImage->move($uploadPath, "original_" . $imageName);

        $this->createImageVersions($filePath, $imageName);

        $checkProductImagePrimary = $this->productImageModel->getPrimaryImage($productId);
        if ($checkProductImagePrimary == null) {
            $relativePath = 'uploads/products/' . $productId . '/' . $newId . '/thumbnail_' . $imageName;
            $isPrimary = true;
        } else {
            $relativePath = 'uploads/products/' . $productId . '/' . $newId . '/medium_' . $imageName;
            $isPrimary = false;
        }

        $updateData = [
            'id' => $newId,
            'product_id' => $productId,
            'image_path' => $relativePath,
            'is_primary' => $isPrimary,
        ];
        $this->productImageModel->save($updateData);

        return redirect()->to("/product/detail/{$productId}");
    }


    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == 'GET') {
            $data['productsImage'] = $this->productImageModel->find($id);
            return view('/product/v_product_image_form', $data);
        }

        $imageData = $this->productImageModel->find($id);

        $productId = $imageData->product_id;
        $productImage = $this->request->getFile('userfile');
        $isPrimary = $this->request->getPost('is_primary');
        $isPrimary = filter_var($isPrimary, FILTER_VALIDATE_BOOLEAN);
        $productName = $this->productModel->find($productId)->name;

        $uploadPath = FCPATH . 'uploads/products/' . $productId . '/' . $id . '/';

        if ($productImage && $productImage->isValid()) {

            $validationRules = [
                'userfile' => [
                    'label' => 'Gambar',
                    'rules' => [
                        'is_image[userfile]',
                        'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                        'max_size[userfile,5120]', // 5MB in KB (5 * 1024)
                    ],
                    'errors' => [
                        'is_image' => 'File Must be an Image',
                        'mime_in' => 'File must be in format JPG, JPEG, PNG, WEBP, or GIF',
                        'max_size' => 'File size must not exceed more than 5MB'
                    ]
                ]
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->deleteFolder(dirname(FCPATH . $imageData->image_path));

            $imageName = "{$productId}_{$productName}_{$id}" . '.' . $productImage->getClientExtension();

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $filePath = $uploadPath . 'original_' . $imageName;
            $productImage->move($uploadPath, "original_" . $imageName);
            $this->createImageVersions($filePath, $imageName);

        } else {
            // get the filename and the .jpg or .png or anything else
            $existingFileName = basename($imageData->image_path);
            $existingExtension = pathinfo($existingFileName, PATHINFO_EXTENSION);

            $imageName = "{$productId}_{$productName}_{$id}" . ".{$existingExtension}";
        }

        if ($isPrimary) {
            $relativePath = 'uploads/products/' . $productId . '/' . $id . '/' . 'thumbnail_' . $imageName;
        } else {
            $relativePath = 'uploads/products/' . $productId . '/' . $id . '/' . 'medium_' . $imageName;
        }
        $formData = [
            'id' => $id,
            'image_path' => $relativePath,
            'is_primary' => $isPrimary
        ];

        if (!$this->productImageModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->productImageModel->errors());
        }

        $this->productImageModel->save($formData);

        return redirect()->to("/product/detail/{$productId}")->with('success', 'Image updated successfully.');
    }



    public function delete($id)
    {
        $image = $this->productImageModel->find($id);
        if ($image) {
            $folderPath = dirname(FCPATH . $image->image_path);
            $this->deleteFolder($folderPath);
            $this->productImageModel->delete($id);
        }
        return redirect()->to("/product/detail/{$image->product_id}");
    }


    private function createImageVersions($filePath, $fileName)
    {
        $date = date('Y');

        $image = service('image');

        $directory = dirname($filePath);


        $image->withFile($filePath)
            ->resize(150, 150, true, 'height')
            ->save($directory . "/" . "thumbnail_" . $fileName);

        $image->withFile($filePath)
            ->text('Copyright ' . $date . ' My Photo Co', [
                'color' => '#fff',
                'opacity' => 1,
                'withShadow' => true,
                'hAlign' => 'center',
                'vAlign' => 'bottom',
                'fontSize' => 50,
            ])
            ->resize(500, 500, true, 'height')
            ->save($filePath, 80);

        $image->withFile($filePath)
            ->text('Copyright' . $date . 'My Photo Co', [
                'color' => '#fff',
                'opacity' => 1,
                'withShadow' => true,
                'hAlign' => 'center',
                'vAlign' => 'bottom',
                'fontSize' => 50,
            ])
            ->resize(500, 500, true, 'height')
            ->save($directory . "/" . "medium_" . $fileName);

    }

    private function deleteFolder($folderPath)
    {
        if (!is_dir($folderPath)) {
            return;
        }

        foreach (scandir($folderPath) as $file) {
            if ($file == '.' || $file == '..')
                continue;
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

            if (is_dir($filePath)) {
                $this->deleteFolder($filePath); // Recursive delete
            } else {
                unlink($filePath);
            }
        }

        rmdir($folderPath);
    }
}
