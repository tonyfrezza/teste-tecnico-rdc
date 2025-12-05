# Sistema de Pedidos - Desafio Técnico PHP Pleno TEC-RDC

Este projeto implementa um sistema completo de pedidos, incluindo backend (API RESTful em Laravel 12, PHP 8.3) conforme o desafio prático da TEC-RDC. O objetivo é demonstrar modelagem de dados, aplicação de regras de negócio reais, código limpo, arquitetura profissional e documentação clara.

---

## 📋 Sumário

- [Sobre o Projeto](#sobre-o-projeto)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instruções de Instalação](#instruções-de-instalação)
- [Configuração do .env](#configuração-do-env)
- [Rodando as Migrations](#rodando-as-migrations)
- [Execução da API](#execução-da-api)
- [Testando os Endpoints](#testando-os-endpoints)
- [Decisões Técnicas](#decisões-técnicas)
- [Diferenciais Implementados](#diferenciais-implementados)
- [Observações Finais](#observações-finais)

---

## Sobre o Projeto

Sistema de Pedidos com as seguintes funcionalidades:

- Cadastro de pedidos com múltiplos itens.
- Cálculo automático de subtotal, total, desconto e imposto.
- Workflow de status: `draft → pending → paid` e `pending → cancelled`.
- Soft delete de pedidos.
- API RESTful.

---

## Tecnologias Utilizadas

- **PHP 8.3** (tipos estritos)
- **Laravel 12**
- **MySQL 8**
- **Composer**
- **Docker**
- **Redis**
- **Repository/DTO/Service Pattern**

---

## Instruções de Instalação

### 1. Clonar o Repositório

```bash
git clone https://github.com/tonyfrezza/teste-tecnico-rdc.git
cd teste-tecnico-rdc
```

### 2. Subir os Containers com Docker (Recomendado)

```bash
cd docker
docker compose up -d
```

- Isso irá subir os serviços: **rdc-laravel**, **rdc-mysql**, **rdc-redis**.

### 3. Instalar Dependências do Backend

Acesse o container do Laravel:

```bash
docker exec -it rdc-laravel bash
```

Dentro do container, execute:

```bash
composer install
```

Se não usar Docker, instale o PHP 8.3+, MySQL 8+ e Composer localmente.

---

## Configuração do .env

No diretório `/codigo`, copie o arquivo de exemplo:

```bash
cp .env.example .env
```

Edite o arquivo `.env` conforme necessário. Exemplo para Docker:

```
DB_CONNECTION=mysql
DB_HOST=rdc-mysql
DB_PORT=3306
DB_DATABASE=rdc
DB_USERNAME=rdc
DB_PASSWORD=MySql102030@

REDIS_HOST=rdc-redis
REDIS_PASSWORD=Redis2019!
REDIS_PORT=6379
```

Ajuste as variáveis se estiver rodando localmente.

---

## Rodando as Migrations

No terminal do container ou local:

```bash
php artisan migrate
```

---

## Execução da API

A API estará disponível em [http://localhost:8080](http://localhost:8080) (ou porta configurada).

---

## Testando os Endpoints

### Exemplos de Endpoints

- **Criar pedido**

  - `POST /orders`
  - Corpo JSON:
    ```json
    {
      "customer_name": "João da Silva",
      "discount": 10,
      "tax": 5,
      "note": "Pedido urgente",
      "items": [
        {
          "product_name": "Produto A",
          "quantity": 2,
          "unit_price": 50
        }
      ]
    }
    ```

- **Listar pedidos**

  - `GET /orders?status=pending&customer_name=João`

- **Visualizar pedido**

  - `GET /orders/{id}`

- **Atualizar status**

  - `PUT /orders/{id}/status`
  - Corpo JSON:
    ```json
    { "status": "pending" }
    ```

- **Excluir pedido (soft delete)**
  - `DELETE /orders/{id}`

Use ferramentas como [Insomnia](https://insomnia.rest/) ou [Postman](https://www.postman.com/) para testar.

---

## Decisões Técnicas

- **Laravel 12**: Framework robusto, com suporte a padrões modernos, migrations, Eloquent ORM e validação.
- **Repository/DTO/Service Pattern**: Separação clara de responsabilidades, facilitando manutenção e testes.
- **Validações**: Todas as regras de negócio são validadas no backend evitando injections e manipulações indevidas de dados.
- **Soft Delete**: Implementado via `deleted_at` no Eloquent com uso de `Model Trait SoftDelets`.
- **Cálculos**: Subtotal e total calculados automaticamente, nunca aceitos do usuário.
- **Status Workflow**: Transições validadas conforme regras do desafio.
- **Docker**: Facilita setup e portabilidade.
- **Redis**: Suporte a cache, pronto para produção.

## Diferenciais Implementados

- [x] Docker funcional
- [x] Repository Pattern, DTOs, Services
- [x] Cache com Redis
- [ ] Documentação via Swagger
- [ ] Testes unitários
- [x] Soft delete
- [ ] Frontend simples responsivo

---

## Observações Finais

- O projeto segue as melhores práticas de arquitetura e organização de código.
- Todas as regras do desafio foram implementadas e validadas.
- O código está pronto para ser avaliado e explicado na entrevista técnica.
- Observação sobre o prazo: O teste foi proposto para execução em 20h (04/12/2025 13:00h a 05/12/2025 9:00h), o que exigiu foco na entrega funcional e nas regras de negócio críticas, priorizando backend, cálculos e workflow de status.

---

**Desenvolvido para o processo seletivo TEC-RDC | Excelência em Tecnologia e Soluções Empresariais**
