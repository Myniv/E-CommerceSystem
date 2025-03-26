<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Libraries\DataParams;
use App\Models\CategoryModel;
use App\Models\M_Product;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Models\UserModel;
use CodeIgniter\Files\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment as Alignment;

class ProductController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $userModel;

    private $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "category_id" => $this->request->getGet("category_id"),
            "price_range" => $this->request->getGet("price_range"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
        ]);

        $result = $this->productModel->getFilteredProducts($params);

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'categories' => $this->categoryModel->findAll(),
            'statuss' => $this->productModel->getAllStatus(),
            'baseUrl' => base_url('product'),
        ];

        return view("product/v_product_list", $data);
    }

    public function productCatalog()
    {
        $parser = \Config\Services::parser();

        $categoryId = $this->request->getGet("category_id");
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "category_id" => $categoryId,
            "price_range" => $this->request->getGet("price_range"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
        ]);

        $result = $this->productModel->getFilteredProducts($params, true);

        // print_r($result['products']);
        foreach ($result['products'] as &$product) {
            if ($product->image_path != null) {
                $product->image_path = base_url($product->image_path);
            } else {
                $product->image_path = base_url('products/search-image.svg');
            }

            if ($product->stock > 10) {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "Available"]);
            } elseif ($product->stock < 10 && $product->stock > 0) {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "Limited"]);
            } else {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "SOLD OUT"]);
            }

            if (strtolower($product->is_new) == 'true') {
                $product->is_new_message = view_cell('ColorTextCell', ['text' => "NEW", 'item' => 'is_new']);
            } else {
                $product->is_new_message = "";
            }

            if (strtolower($product->is_sale) == 'true') {
                $product->is_sale_message = view_cell('ColorTextCell', ['text' => "SALE", 'item' => 'is_sale']);
            } else {
                $product->is_sale_message = "";
            }

            $product->priceFormat = $product->getFormattedPrice();
            $product->created_atFormat = $product->created_at->humanize();
        }

        $categories = $this->categoryModel->findAll();
        foreach ($categories as &$category) {
            $category->selected = ($category->id == $categoryId) ? 'selected' : '';
        }

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager']->links('products', 'custom_pager'),
            'total' => $result['total'],
            'search' => $params->search,
            'reset' => $params->getResetUrl(base_url('product/catalog')),
            'order' => $params->order,
            'sort' => $params->sort,
            'page' => $params->page,
            'categories' => $categories,
            'statuss' => $this->productModel->getAllStatus(),
            'baseUrl' => base_url('product/catalog'),
            'perPageOptions' => [
                ['value' => 2, 'selected' => ($params->perPage == 2) ? 'selected' : ''],
                ['value' => 5, 'selected' => ($params->perPage == 5) ? 'selected' : ''],
                ['value' => 10, 'selected' => ($params->perPage == 10) ? 'selected' : ''],
                ['value' => 25, 'selected' => ($params->perPage == 25) ? 'selected' : ''],
            ],
            'sorting' => [
                [
                    'name' => 'Price',
                    'href' => $params->getSortUrl('price', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : '↕'
                ],
                [
                    'name' => 'Name',
                    'href' => $params->getSortUrl('name', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : '↕'
                ],
                [
                    'name' => 'Date',
                    'href' => $params->getSortUrl('created_at', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('created_at') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : '↕'
                ],
            ],
            'priceRangeOptions' => [
                ['value' => '0-50000', 'label' => 'Rp 0 - Rp 49.999', 'selected' => ($params->price_range == "0-50000") ? 'selected' : ''],
                ['value' => '50000-100000', 'label' => 'Rp 50.000 - Rp 99.999', 'selected' => ($params->price_range == "50000-100000") ? 'selected' : ''],
                ['value' => '100000-500000', 'label' => 'Rp 100.000 - Rp 49.999', 'selected' => ($params->price_range == "100000-500000") ? 'selected' : ''],
                ['value' => '500000-1000000', 'label' => 'Rp 500.000 - Rp 999.999', 'selected' => ($params->price_range == "500000-1000000") ? 'selected' : ''],
                ['value' => '1000000', 'label' => '> Rp 1.000.000', 'selected' => ($params->price_range == "1000000") ? 'selected' : '']
            ]
        ];

        if (!cache()->get("product-catalog")) {
            // cache()->save("product-catalog", $data['products'], 3600);
        }

        $data['content'] = $parser->setData($data)->render('product/v_product_catalog_parser');

        return view("components/v_parser_layout_master", $data);
    }



    public function show($id = null)
    {
        $data['products'] = $this->productModel->getProductWithCategories()->find($id);
        $data['image_primary'] = $this->productModel->getProductImagePrimary()->find($id);
        // dd($data['products']);

        $data['product_images'] = $this->productImageModel->getAllProductImageByProductId($id);
        return view('/product/v_product_detail', $data);
    }

    public function new()
    {
        $data['activeornot'] = ['Active', 'Inactive'];
        $data['trueorfalse'] = ['True', 'False'];
        $data['categories'] = $this->categoryModel->select('id, name')->findAll();
        return view("/product/v_product_form", $data);
    }

    public function create()
    {
        $validationRules = [
            'userfile' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[userfile]',
                    'is_image[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[userfile,5120]', // 5MB in KB (5 * 1024)
                    'min_dims[userfile,600,600]',
                ],
                'errors' => [
                    'uploaded' => 'Choose Uploaded File',
                    'is_image' => 'File Must be an Image',
                    'mime_in' => 'File must be in format JPG, JPEG, PNG, WEBP, or GIF',
                    'max_size' => 'File size must not exceed more than 5MB',
                    'min_dims' => 'Image must be at least 600x600',
                ]
            ]
        ];

        $formData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'is_new' => $this->request->getPost('is_new'),
            'is_sale' => $this->request->getPost('is_sale'),
        ];

        $productImage = $this->request->getFile('userfile');

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!$this->productModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        $this->productModel->save($formData);
        $productId = $this->productModel->getInsertID();
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

        $relativePath = 'uploads/products/' . $productId . '/' . $newId . '/thumbnail_' . $imageName;


        // Save image data to the database
        $productImageData = [
            'id' => $newId,
            'product_id' => $productId,
            'image_path' => $relativePath,
            'is_primary' => true
        ];
        $this->productImageModel->save($productImageData);

        // Send Email
        $category = $this->categoryModel->find($formData['category_id']);
        $ccUsers = $this->userModel->getUserWithRoleAdminPM();
        $ccList = array_column($ccUsers, 'email');
        $ccNames = array_column($ccUsers, 'username');
        $ccNamesString = implode(', ', $ccNames);

        $email = service('email');
        $email->setFrom('mulyanan@solecode.id');
        $email->setTo(user()->email);
        $email->setCC($ccList);
        $email->setSubject('New Product');

        $data = [
            'title' => 'New Product Has Been Added',
            'name' => $ccNamesString,
            'content' => user()->username . ' has added a new product. Please check it out.',
            'features_title' => 'Product Details',
            'features' => [
                'Name : ' . $formData['name'],
                'Description : ' . $formData['description'],
                'Category : ' . $category->name,
                'Price : ' . $formData['price'],
                'Stock : ' . $formData['stock'],
                'View Product : ' . base_url('product/' . $productId)
            ],
        ];

        $email->setMessage(view('auth/emails/email_template', $data));

        $thumbnailPath = $this->productImageModel->getPrimaryImage($productId)->image_path;

        $absolutePath = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, ltrim($thumbnailPath, '/'));
        // dd($absolutePath);
        if (file_exists($absolutePath)) {
            $email->attach($absolutePath);
        } else {
            die("Error: File does not exist.");
        }

        $email->send();
        cache()->delete("product-catalog");

        return redirect()->to("product");
    }


    public function edit($id = null)
    {
        $product = $this->productModel->find($id);

        $data['activeornot'] = ['Active', 'Inactive'];
        $data['trueorfalse'] = ['True', 'False'];
        $data['categories'] = $this->categoryModel->select('id, name')->findAll();
        $data["products"] = $product;
        return view("/product/v_product_form", $data);
    }

    public function update($id = null)
    {
        $formData = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            // 'category_id' => explode(",", $this->request->getPost('category_id')),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'is_new' => $this->request->getPost('is_new'),
            'is_sale' => $this->request->getPost('is_sale'),
        ];


        if (!$this->productModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        cache()->delete("product-catalog");

        $this->productModel->save($formData);
        return redirect()->to("product");
    }


    public function delete($id = null)
    {
        $this->productModel->delete($id);
        cache()->delete("product-catalog");
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

    public function reportProductExcel()
    {
        $category_id = $this->request->getGet("category_id");
        if (!empty($category_id)) {
            $products = $this->productModel->getProductsByCategory($category_id);
            $categoryName = $this->categoryModel->find($category_id)->name;
            $name = $this->categoryModel->find($category_id)->name;
            $filename = 'Reports_Product_With_Category_' . $categoryName . '_' . date('Y-m-d-His') . '.xlsx';
        } else {
            $products = $this->productModel->getAllProductsWithCategories();
            $filename = 'Reports_Product_' . date('Y-m-d-His') . '.xlsx';
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Products Report');
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Filter');
        $sheet->setCellValue('B3', 'Category Id :' . ($category_id ?? 'All'));
        $sheet->setCellValue('D3', 'Category Name:' . ($name ?? 'All'));
        $sheet->getStyle('A3:D3')->getFont()->setBold(true);

        $headers = [
            'A5' => 'No',
            'B5' => 'Name',
            'C5' => 'Price',
            'D5' => 'Stock',
            'E5' => 'Category',
            'F5' => 'Status',
            'G5' => 'Is New',
            'H5' => 'Is Sale',
            'I5' => 'Created Add',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 6;
        $no = 1;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $product->name);
            $sheet->setCellValue('C' . $row, $product->price);
            $sheet->setCellValue('D' . $row, $product->stock);
            $sheet->setCellValue('E' . $row, $product->category_name);
            $sheet->setCellValue('F' . $row, $product->status);
            $sheet->setCellValue('G' . $row, $product->is_new);
            $sheet->setCellValue('H' . $row, $product->is_sale);
            $sheet->setCellValue('I' . $row, $product->created_at);

            $row++;
            $no++;
        }

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A5:J' . ($row - 1))->applyFromArray($styleArray);




        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function dashboardProducts()
    {
        $data['percentageProductsByCategory'] = json_encode($this->getPercentageProductsByCategory());
        $data['highestCategoriesOfProducts'] = json_encode($this->get5HighestCategoriesOfProducts());
        $data['productsPerMonth'] = json_encode($this->getProductsPerMonth());
        // print_r($data['creditComparison']);

        return view('dashboard/v_dashboard_products', $data);
    }

    //Pie chart
    private function getPercentageProductsByCategory()
    {
        $data = [];
        $products = $this->categoryModel->getProductPercentageByCategory();
        // dd($products);   

        foreach ($products as $product) {
            $data[] = [
                'category_name' => $product->category_name,
                'percentage' => round($product->percentage, 2),
                'product_count' => $product->product_count,
            ];
        }

        $categories = $this->categoryModel->select('name')->findAll();

        $backgroundColors = [];
        foreach ($categories as $row) {
            $backgroundColors[$row->name] = 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
        }
        // dd($backgroundColors);


        // $backgroundColors = [
        //     'Shoes' => 'rgb(54, 162, 235)', // Biru 
        //     'Tshirt' => 'rgb(75, 192, 192)', // Cyan 
        //     'Food' => 'rgb(153, 102, 255)', // Ungu 
        //     'Drink' => 'rgb(255, 205, 86)', // Kuning
        //     'C' => 'rgb(255, 159, 64)', // Oranye 
        //     'D' => 'rgb(255, 99, 132)' // Merah
        // ];

        $labels = [];
        $counts = [];
        $colors = [];
        foreach ($data as $row) {
            $labels[] = $row['category_name'] . '=' . $row['percentage'] . ' %';
            $counts[] = (int) $row['product_count'];
            $colors[] = $backgroundColors[$row['category_name']];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Products',
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4
                ]
            ]
        ];
    }

    //Bar chart
    private function get5HighestCategoriesOfProducts()
    {
        $categories = $this->categoryModel->get5HighestProductByCategory();

        $labels = [];
        $productCount = [];
        foreach ($categories as $row) {
            $labels[] = 'Category : ' . $row->category_name;
            $productCount[] = (int) $row->product_count;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Category',
                    'data' => $productCount,
                    'backgroundColor' => 'rgba(158, 0, 61, 0.5)',
                    'borderColor' => 'rgb(86, 3, 10)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    private function getProductsPerMonth()
    {
        $data = $this->productModel->getProductsPerMonth();
        // dd($data);

        $month = [];
        $product = [];
        foreach ($data as $row) {
            $month[] =  $row['month'];
            $product[] = $row['product_count'];
            // $gpaData[] = $row['gpa'];
        }

        return [
            'labels' => $month,
            'datasets' => [
                [
                    'label' => 'Product',
                    'data' => $product,
                    'borderColor' => 'rgb(129, 8, 8)',
                    'tension' => 0.1,
                    'fill' => false
                ]
            ]
        ];
    }


}
