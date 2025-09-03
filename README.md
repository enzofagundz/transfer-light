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

Foram adicionadas ferramentas para manter consistência e padrões no projeto:

- **Laravel Pint**: padronização de estilo de código conforme PSRs.
- **PHPStan** (nível 5): análise estática para detectar erros potenciais antes da execução.
- **Rector**: automatização de refatorações e aplicação de boas práticas modernas de PHP.

> Escolhi usar estas ferramentas para mostrar preocupação com manutenção e clareza a longo prazo, além de facilitar evolução futura do projeto.

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

- **Separação de responsabilidades**: uso de Repository/Service para manter a lógica de domínio isolada dos controllers, evitando acoplamento excessivo.
- **Enums tipados**: usados no lugar de magic numbers e valores fixos dispersos no código, melhorando clareza e consistência. São persistidos como inteiros no banco, aproveitando melhor desempenho em consultas e índices.
- **Eventos e Jobs**: notificação de recebimento será tratada de forma assíncrona, para evitar travar o fluxo principal em caso de falhas externas.
- **Cache seletivo**: aplicado em pontos de leitura não críticos (ex: busca de usuários), mas **não** para valores mutáveis como saldo, para evitar inconsistências.

---

## 🧪 Testes

O projeto utiliza **Pest** como framework de testes.

### Como rodar os testes

```bash
./vendor/bin/sail test

# or

./vendor/bin/sail artisan test
```
