<?php

namespace App\Controller;

use App\Service\SaleService;
use App\Controller\AbstractController;

class SaleController extends AbstractController
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
            $sales = SaleService::getAll();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $sales;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir todas as vendas');
        }

        return $response;
    }

    public function getOnly($id)
    {
        try {
            $sale = SaleService::getOnly($id);

            if (!$sale) return $this->notFound();

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $sale;
        } catch (\Exception $e) {
            return $this->error('Erro ao exibir venda');
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
            SaleService::create($params);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel criar venda');
        }

        return $response;
    }

    public function update($id)
    {
        return $this->notFound();
    }

    public function delete($id)
    {
        try {
            $sale = SaleService::getOnly($id);

            if (!$sale) return $this->notFound();

            SaleService::delete($id);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
        } catch (\Exception $e) {
            return $this->error('Não foi possivel deletar venda');
        }

        return $response;
    }

    private function validate($params)
    {
        if (empty($params['itens']) || !is_array($params['itens'])) {
            return false;
        }

        return true;
    }
}
