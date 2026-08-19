# Registo de decisões

Porque é que o código está como está. Duas ou três linhas por decisão, escritas
no momento em que a decisão é tomada.

O código mostra sempre o *quê*; nunca mostra o *porquê*, nem as alternativas
descartadas.

**Registar quando:** se escolhe entre alternativas, se descarta uma abordagem
óbvia, ou se faz algo que daqui a seis meses vai parecer estranho.
Não registar o trivial.

---

## 2026-08-19 — Laravel headless na raiz + Next.js em `frontend/`

**Contexto:** a skill de arranque propõe um starter kit (Livewire/React/Vue/Svelte). O Pedro escolheu Laravel + Next.js.

**Decisão:** Laravel 13 sem starter kit (`composer create-project` + `php artisan install:api`) na raiz do repositório; Next.js 16 (App Router, TS, Tailwind 4) em `frontend/`. O Laravel é só API JSON; toda a UI está no Next.

**Porquê:** Livewire chegava para 3 ecrãs, mas a preferência é por Next no frontend. Monorepo `api/` + `web/` seria mais limpo, mas obrigava a adaptar hooks, Boost, `ci.yml` e a skill para subpasta — Laravel na raiz mantém tudo isso intacto.

**Consequências:** CI com dois jobs (Pest + `next lint/build`). Dois servidores em dev (`artisan serve` + `next dev`). CORS/`NEXT_PUBLIC_API_URL` a configurar no primeiro ecrã. Sanctum instalado mas sem login (app local).

---

## 2026-08-19 — MySQL em dev e nos testes (não SQLite)

**Contexto:** o default do Laravel é SQLite, zero configuração.

**Decisão:** MySQL 8.4 (Laragon local) — `teste` em dev, `teste_test` nos testes; `phpunit.xml` e o serviço MySQL do CI usam os mesmos valores (root, sem password).

**Porquê:** escolha do Pedro; evita divergência entre o motor local e o de produção futuro. Testes e CI correm no mesmo motor que o dev.

**Consequências:** testes exigem MySQL a correr (local: Laragon; CI: service container). Sem SQLite em lado nenhum.

---

## 2026-08-19 — Deploy adiado

**Contexto:** a app é local, utilizador único.

**Decisão:** não configurar deploy nesta fase. Quando for preciso, decidir entre Ploi e outro e registar aqui.

**Consequências:** nada de Ploi/servidor por agora; `.env.example` mantém-se genérico.

---
