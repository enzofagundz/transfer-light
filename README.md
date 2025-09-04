# Transfer Light

Este projeto é uma aplicação de transferências simplificada, construída utilizando o **TALL Stack** (Tailwind, AlpineJS, Laravel e Livewire).

## 🎯 Objetivo

O sistema permite que usuários comuns e lojistas realizem transferências de dinheiro entre si, respeitando regras de negócio específicas:

- Usuários podem enviar e receber transferências.
- Lojistas apenas recebem transferências.
- Validação de saldo antes de transferir.
- Autorização via serviço externo.
- Notificação de recebimento via serviço externo (assíncrono, sujeito a falhas).
- Transações devem ser atômicas (rollback em caso de falha).

## 🛠️ Stack

- **Laravel** 12.x
- **Laravel Sail** (Docker)
- **Livewire** + **AlpineJS**
- **TailwindCSS** + **DaisyUI**
- **Pest** para testes
- **Laravel Pint**, **PHPStan** e **Rector** para qualidade

---

## 🔍 Qualidade de Código

Este projeto utiliza ferramentas para garantir consistência e detectar problemas cedo:

- **Laravel Pint** → padronização de estilo de acordo com PSRs.  
- **PHPStan + Larastan** (nível 5) → análise estática que compreende Eloquent, facades e helpers do Laravel. Equilibra profundidade e viabilidade para o contexto deste teste.  
- **Rector** → automatiza refatorações e garante uso de boas práticas modernas de PHP.  

> Essas ferramentas foram escolhidas para reduzir riscos de regressões, manter legibilidade e facilitar evolução futura.

---

## Detalhes sobre a stack voltada para qualidade de código

### PHPStan + Larastan

Este projeto utiliza [Larastan](https://github.com/larastan/larastan), um plugin do PHPStan específico para Laravel, que adiciona regras de análise para:

- Models Eloquent
- Facades
- Helpers do framework

Isso aumenta a precisão da análise estática, detectando problemas que o PHPStan puro não conseguiria.

- **Nível configurado**: 5  
Escolhido por equilibrar profundidade de análise e viabilidade no contexto do teste técnico.  
- **Pastas analisadas**: `app/` e `tests/`.  

---

## 🚀 Setup do Projeto

Este projeto utiliza **Laravel Sail** para simplificar a execução em Docker.

### Como rodar

1; Clone o repositório

```bash
   git clone git@github.com:SEU_USUARIO/transfer-light.git
   cd transfer-light
```

2; Suba os containers

```bash
./vendor/bin/sail up -d
```

3; Rode as migrations

```bash
./vendor/bin/sail artisan migrate
```

4; Acesse em `http://localhost`

5; Popule dados de exemplo (usuários, carteiras, saldos)

```bash
./vendor/bin/sail artisan db:seed
```

---

## 🏗️ Decisões de Arquitetura

- **Separação de responsabilidades**: uso de Repository/Service para manter a lógica de domínio isolada dos controllers. Isso facilita testes unitários e evita que regras de negócio fiquem espalhadas em camadas de apresentação.
- **Enums tipados**: usados no lugar de magic numbers e valores fixos dispersos no código, melhorando clareza e consistência. São persistidos como inteiros no banco, aproveitando melhor desempenho em consultas e índices.
- **Eventos e Jobs**: notificação de recebimento será tratada de forma assíncrona, para evitar travar o fluxo principal em caso de falhas externas.
- **Cache seletivo**: aplicado em pontos de leitura não críticos (ex: busca de usuários), mas **não** para valores mutáveis como saldo, para evitar inconsistências.

---

## 🧪 Testes

O projeto utiliza **Pest** como framework de testes.

- **Testes unitários** → garantir a lógica de transferência (ex: saldo insuficiente, lojista não pode enviar).  
- **Testes de integração** → validar o fluxo completo de uma transferência via Livewire.

### Como rodar os testes

```bash
./vendor/bin/sail test

# or

./vendor/bin/sail artisan test
```

## 🧪 Estratégia de Testes

Não implementei testes unitários para as classes genéricas (`BaseRepository`, `BaseService`), porque elas são simples delegadores ao Eloquent, já testados pelo próprio framework.

Foquei em testes para as **regras de negócio críticas**:

- Fluxo de transferência (`TransferService`).
- Respeito às regras de saldo.
- Comportamento em caso de falha no autorizador externo.
- Garantia de rollback em caso de inconsistência.

---

## 🌱 Fluxo de Git

Adotei um fluxo baseado em **Git Flow simplificado** para manter o histórico organizado:

- `main` → branch estável, usada apenas para entregas finais.
- `develop` → branch de integração, onde os PRs de features são revisados antes do merge final.
- `feature/*` → branches criadas para cada entrega incremental (ex: `feature/modelagem`, `feature/transfer-service`).

Essa escolha facilita colaboração, evita commits diretos na `main` e simula um ambiente real de equipe.

---

## 🗂️ Modelagem de Dados

A modelagem foi pensada para refletir as regras de negócio do desafio:

- **Users** → armazena usuários comuns e lojistas, diferenciados por enum `UserType`.  
- **Wallets** → armazena saldo de cada usuário de forma isolada.  
- **Transactions** → registra transferências entre usuários, com enum `TransactionStatus` para representar o estado.  

### Estrutura Simplificada

- `users (id, name, cpf_cnpj, email, password, type)`  
- `wallets (id, user_id, balance)`  
- `transactions (id, sender_id, receiver_id, amount, status)`  

### Regras

- `cpf_cnpj` e `email` são únicos no sistema.  
- `wallets.user_id` é único (1–1).  
- Saldo precisa ser validado em toda operação.  
- Transações são atômicas (se algo falhar, rollback).
