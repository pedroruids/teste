# Progresso — teste

Estado do arranque (playbook `/novo-projeto`). Actualizar ao fechar cada fase.

| Fase | O que produz | Estado |
|---|---|---|
| **A — Enquadramento** | `docs/PRODUTO.md` — problema, público, fronteiras, v1 | ✅ 2026-08-19 |
| **B — Fluxos** | F1/F2/F3, 3 ecrãs, entidades (em `docs/PRODUTO.md`) | ✅ 2026-08-19 |
| **C — Esqueleto técnico** | Laravel 13 + Next 16, Boost, Pest 5, CI verde, repo `pedroruids/teste`, labels, ruleset, hooks, 13 issues | ✅ 2026-08-19 |
| **D — Sistema visual** | `docs/DESIGN.md` ✅ + tokens ✅ · componentes base + `/design` → issue #2 | ⬜ |
| **E — Ecrãs** | Mockups `docs/mockups/{converter,historico,lote}.html` → issues #3 #4 #5 (`/desenhar-ecra`) | ⬜ |
| **F — Arquitectura** | `docs/ARCHITECTURE.md` + migrações → issue #6 (depois dos ecrãs) | ⬜ |

## Próximo passo
1. Aceitar o diálogo de confiança da pasta no Claude Code (sem isso os hooks não correm).
2. `/desenhar-ecra converter` (issue #3) — ou começar pela Fase D (issue #2).

## Por fazer / adiado
- Deploy — adiado (`docs/DECISIONS.md`).
- Ruleset `proteger-main`: exige 1 aprovação; admin tem bypass **só em PR** (projecto solo). Push directo na `main` continua bloqueado.
