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
                    'max_size[userfile,5120]', // 5MB in KB (5 * 1024)
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG, WEBP, or GIF',
                    'max_size' => 'File size must not exceed more than 5MB'
                ]
            ]
        ];

        $productImage = $this->request->getFile('userfile');

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $randomName = $productImage->getRandomName();
        $uploadPath = FCPATH . 'uploads/products/' . $productId . '/' . $randomName . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $productName = $this->productModel->find($productId)->name;

        $imageName = $productId . '_' . $productName . '_' . $productImage->getClientName() . '_' . date('Y-m-d_H-i-s') . '.' . $productImage->getClientExtension();
        $filePath = $uploadPath . 'original_' . $imageName;
        $productImage->move($uploadPath, "original_" . $imageName);

        $this->createImageVersions($filePath, $imageName);


        $formData = [];
        $checkProductImagePrimary = $this->productImageModel->getPrimaryImage($productId);
        if ($checkProductImagePrimary == null) {
            $relativePath = 'uploads/products/' . $productId . '/' . $randomName . '/thumbnail_' . $imageName;
            $formData = [
                'product_id' => $productId,
                'image_path' => $relativePath,
                'is_primary' => true,
            ];
        } else {
            $relativePath = 'uploads/products/' . $productId . '/medium_' . $imageName;
            $formData = [
                'product_id' => $productId,
                'image_path' => $relativePath,
            ];
        }

        $this->productImageModel->save($formData);

        return redirect()->to("product");
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == 'GET') {
            $data['productsImage'] = $this->productImageModel->find($id);
            return view('/product/v_product_image_form', $data);
        }

        $validationRules = [
            'userfile' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[userfile,5120]', // 5MB in KB (5 * 1024)
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG, WEBP, or GIF',
                    'max_size' => 'File size must not exceed more than 5MB'
                ]
            ]
        ];

        $productId = $this->productImageModel->find($id)->product_id;
        $productImage = $this->request->getFile('userfile');
        $isPrimary = $this->request->getPost('is_primary');

        $randomName = $productImage->getRandomName();
        $formData = [];
        if ($productImage != null) {

            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            //Delete old image
            $image = $this->productImageModel->find($id);
            $folderPath = dirname(FCPATH . $image->image_path);
            $this->deleteFolder($folderPath);


            $uploadPath = FCPATH . 'uploads/products/' . $productId . '/' . $randomName . '/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $productName = $this->productModel->find($productId)->name;

            $imageName = $productId . '_' . $productName . '_' . $productImage->getFilename() . '_' . date('Y-m-d_H-i-s') . '.' . $productImage->getClientExtension();
            $filePath = $uploadPath . 'original_' . $imageName;
            $productImage->move($uploadPath, "original_" . $imageName);

            $this->createImageVersions($filePath, $imageName);
        }

        if ($isPrimary == null || $isPrimary == false) {
            $relativePath = 'uploads/products/' . $productId . '/' . $randomName . '/' . 'thumbnail_' . $imageName;
            $formData = [
                'image_path' => $relativePath,
            ];
        } else {
            $relativePath = 'uploads/products/' . $productId . '/' . $randomName . '/' . 'medium_' . $imageName;
            $formData = [
                'image_path' => $relativePath,
            ];
        }

        $formData['is_primary'] = $isPrimary;

        $this->productImageModel->save($formData);

        return redirect()->to("product");
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

        rmdir($folderPath); // Remove the folder after files are deleted
    }
}
