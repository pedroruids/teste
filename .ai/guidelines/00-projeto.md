# Contexto do projeto

<!--
Este ficheiro é TEU e vai para o git.

O Laravel Boost inclui automaticamente tudo o que estiver em `.ai/guidelines/`
no CLAUDE.md que gera. Ou seja: escreves aqui, o Boost regenera o CLAUDE.md, e
o teu conteúdo continua lá. Nunca editar o CLAUDE.md à mão.

Manter curto — isto é lido em todas as sessões. Detalhe longo vive em docs/ e
é referenciado, não colado.
-->

## O que é

**teste** — mini plataforma local para converter imagens (JPG/PNG) em WebP optimizados para a web, em lote, com histórico de conversões e log de tudo. Utilizador único (o Pedro), para preparar imagens dos sites que faz. Substitui o Squoosh uma-a-uma.

Detalhe em `docs/PRODUTO.md`.

## Arquitectura em duas peças

- **Raiz** — Laravel 13 headless (API JSON em `routes/api.php`, Sanctum instalado mas sem login: a app é local). Conversão de imagens, histórico e log vivem aqui.
- **`frontend/`** — Next.js 16 (App Router, TypeScript, Tailwind 4). Toda a UI. Fala com a API por `NEXT_PUBLIC_API_URL` (default `http://localhost:8000`).

## Comandos

- Testes: `./vendor/bin/pest`
- Um teste: `./vendor/bin/pest --filter=<nome>`
- Formatação: `./vendor/bin/pint`
- Análise estática: `./vendor/bin/phpstan analyse --memory-limit=1G`
- API em dev: `php artisan serve` (porta 8000)
- Frontend em dev: `cd frontend && npm run dev` (porta 3000)
- Frontend lint/build: `cd frontend && npm run lint && npm run build`
- BD: MySQL local (Laragon) — `teste` em dev, `teste_test` nos testes (`phpunit.xml`)

## Documentos de referência

Ler quando o trabalho os tocar — não estão colados aqui de propósito:

- `docs/PRODUTO.md` — o problema, as fronteiras, os fluxos
- `docs/DESIGN.md` — sistema visual (obrigatório antes de mexer em `frontend/`)
- `docs/ARCHITECTURE.md` — modelo de dados, módulos, packages
- `docs/DECISIONS.md` — porquê das decisões estruturantes
- `REVIEW.md` — critérios de revisão

## Convenções deste projeto

- UI só no `frontend/` — o Laravel não serve Blade de produto (apenas `/up`).
- Tokens visuais em `frontend/app/globals.css` (`@theme`), não em `resources/css/`.
- Português de Portugal (pt-PT) em UI, docs, commits e issues.
- Testes de feature correm em MySQL (`teste_test`), não em SQLite — local e CI iguais.

## Nunca fazer

- Alterar migrações já aplicadas em produção — criar uma nova
- Introduzir cores, tamanhos ou raios fora do `docs/DESIGN.md`
- Escrever testes na mesma sessão em que se implementou o código
- Commitar diretamente na `main`
