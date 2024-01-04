<?php

namespace App\Controller;

use App\Service\CategoryService;
use App\Controller\AbstractController;

class CategoryController extends AbstractController
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
            $categories = CategoryService::getAll();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $categories;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir todas as categories');
        }

        return $response;
    }

    public function getOnly($id)
    {
        try {
            $category = CategoryService::getOnly($id);

            if (!$category) return $this->notFound();

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $category;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir categoria');
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
            CategoryService::create($params);
            $response['status_code_header'] = 'HTTP/1.1 200 Created';
            $response['body'] = json_encode(['message' => 'Criado com sucesso.']);
        } catch (\Exception $e) {
            return $this->error('Não foi possivel criar categoria');
        }

        return $response;
    }

    public function update($id)
    {
        try {
            $category = CategoryService::getOnly($id);

            if (!$category) return $this->notFound();

            $params = $this->getParams();

            if (!$this->validate($params)) {
                return $this->unprocessableEntity();
            }

            CategoryService::update($id, $params);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(['message' => 'Atualizado com sucesso.']);;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel atualizar categoria');
        }

        return $response;
    }

    public function delete($id)
    {
        try {
            $category = CategoryService::getOnly($id);

            if (!$category) return $this->notFound();

            CategoryService::delete($id);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel deletar categoria');
        }

        return $response;
    }

    private function validate($params)
    {
        if (empty($params['title'])) {
            return false;
        }
        if (empty($params['tax'])) {
            return false;
        }
        return true;
    }
}
