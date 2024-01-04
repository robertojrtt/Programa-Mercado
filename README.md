# Programa para Mercado

Desenvolva um programa para um mercado que permita:

- **Cadastro dos Produtos**
  - Permite o cadastro de produtos no sistema.

- **Cadastro dos Tipos de Produtos**
  - Possibilita o registro dos tipos relacionados a cada produto.

- **Cadastro dos Valores Percentuais de Imposto**
  - Permite a inclusão dos valores percentuais de imposto para cada tipo de produto.

- **Tela de Venda**
  - Informa os produtos e suas quantidades durante o processo de venda.

- **Cálculos na Tela de Venda**
  - Apresenta o valor de cada item multiplicado pela quantidade adquirida.
  - Mostra a quantidade paga de imposto em cada item.

- **Totalizadores**
  - Exibe o total do valor da compra.
  - Mostra o total dos valores dos impostos pagos.

- **Persistência de Vendas**
  - Salva as informações da venda realizada.

## Instruções para Configuração e Execução

Certifique-se de ter o PHP 7.4 ou superior instalado em seu ambiente. Além disso, o banco de dados pode ser PostgreSQL ou MSSQL Server. Siga as instruções abaixo para configurar e executar o backend e o frontend.

### Database

1. Execute o backup do banco de dados localizado na raiz do projeto
 

### Backend

1. Altere as configuração do banco em ./backend/src/Config/Connection.php

2. Navegue até a pasta do backend no terminal.
   ```bash
   cd backend
   php -S localhost:8080

### Frontend

1. Navegue até a pasta do frontend no terminal.
   ```bash
   cd frontend
   php -S localhost:3000

### Tecnologias Utilizadas

1. Backend

PHP 7.4 ou superior
Banco de Dados: PostgreSQL ou MSSQL Server
Inicie o servidor PHP na porta 8080.

2. Frontend

Pode ser desenvolvido utilizando bibliotecas como Bootstrap e Material Design.
Frameworks como React, Angular e Vue são opcionais (caso utilizados, enviar o build).