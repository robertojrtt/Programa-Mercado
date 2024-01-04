<?php

namespace App\Controller;

use App\Service\ProductService;
use App\Controller\AbstractController;

class ProductController extends AbstractController
{
    protected $requestMethod;
    protected $id;

    public function __construct($requestMethod, $id = null)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;
        $this->processRequest();
    }

    public function processRequest()
    {
        $response = $this->getAll();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id) {
                    $response = $this->getOnly($this->id);
                } else {
                    $response = $this->getAll();
                };
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->update($this->id);
                break;
            case 'DELETE':
                $response = $this->delete($this->id);
                break;
            default:
                $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
                $response['body'] = null;
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function getAll()
    {
        try {
            $products = ProductService::getAll();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $products;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir todos os produtos');
        }

        return $response;
    }

    public function getOnly($id)
    {
        try {
            $product = ProductService::getOnly($id);

            if (!$product) return $this->notFound();

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $product;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir produto');
        }

        return $response;
    }

    public function create()
    {
        try {
            $params = $this->getParams();

            if (!$this->validate($params)) {
                return $this->unprocessableEntity();
            }
            ProductService::create($params);
            $response['status_code_header'] = 'HTTP/1.1 200 Created';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel criar produto');
        }

        return $response;
    }

    public function update($id)
    {
        try {
            $product = ProductService::getOnly($id);

            if (!$product) return $this->notFound();

            $params = $this->getParams();

            if (!$this->validate($params)) {
                return $this->unprocessableEntity();
            }

            ProductService::update($id, $params);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel atualizar produto');
        }

        return $response;
    }

    public function delete($id)
    {
        try {
            $product = ProductService::getOnly($id);

            if (!$product) return $this->notFound();

            ProductService::delete($id);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel deletar produto');
        }

        return $response;
    }

    private function validate($params)
    {
        if (empty($params['title'])) {
            return false;
        }

        if (!isset($params['description'])) {
            return false;
        }

        if (empty($params['price'])) {
            return false;
        }

        if (empty($params['category_id'])) {
            return false;
        }

        return true;
    }
}
