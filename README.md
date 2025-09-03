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

## 🚀 Setup do Projeto

Este projeto utiliza **Laravel Sail** para simplificar a execução em Docker.

### Como rodar

1. Clone o repositório

```bash
   git clone git@github.com:SEU_USUARIO/transfer-light.git
   cd transfer-light
```

2. Suba os containers

```bash
./vendor/bin/sail up -d
```

3. Rode as migrations

```bash
./vendor/bin/sail artisan migrate
```

4. Acesse em `http://localhost`

---

## 🏗️ Decisões de Arquitetura

- **Separação de responsabilidades**: uso de Repository/Service para manter lógica de domínio isolada dos controladores.
- **Enums tipados**: substituem constantes mágicas e melhoram a clareza. Armazenados como inteiros no banco para maior performance.
- **Eventos e Jobs**: notificação de recebimento será tratada de forma assíncrona, para evitar travar o fluxo principal em caso de falhas externas.
- **Cache seletivo**: aplicado em pontos de leitura não críticos (ex: busca de usuários), mas **não** para valores mutáveis como saldo, para evitar inconsistências.
