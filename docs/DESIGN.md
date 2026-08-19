# Sistema de design

Este ficheiro define as restrições visuais do produto. **Todo o ecrã novo é
composto dentro delas.** Não se introduzem cores, tamanhos ou componentes novos
sem uma decisão explícita registada aqui.

Lido pelo Claude em qualquer sessão de design ou de implementação de interface.

---

## As quatro decisões

Estas são deliberadas e humanas. É aqui que vive a identidade do produto.

**Tipografia:** Geist Sans para interface e títulos; Geist Mono para números tabulares (bytes, percentagens, timestamps). Carregadas via `next/font/google` (`Geist`, `Geist_Mono`) no `frontend/app/layout.tsx`.
Escala: 12 / 14 / 16 / 20 / 24 / 32 / 48

**Cor de marca:** `#7c3aed` (violeta) — usada em ações primárias e estados ativos. Nada mais.
**Neutra:** zinc

**Forma:** raio de cantos `0.75rem` (`--radius-card`) · bordas 1px `zinc-200`

**Densidade:** espaçosa
Unidade base de espaçamento: 8px

---

## Cores

| Uso | Token | Quando |
|---|---|---|
| Primária | `brand-600` (`#7c3aed`) | Ação principal do ecrã — **uma por ecrã** |
| Primária hover | `brand-700` (`#6d28d9`) | Hover/active da primária |
| Primária suave | `brand-50` (`#f5f3ff`) | Fundo de estado activo, realce |
| Texto | `zinc-900` | Corpo |
| Texto secundário | `zinc-500` | Metadados, legendas |
| Fundo | `white` / `zinc-50` | Página e superfícies |
| Borda | `zinc-200` | Separadores, contornos |
| Sucesso / Aviso / Erro | `emerald-600` / `amber-600` / `red-600` | Apenas feedback de estado |

Regra: **cor comunica, não decora.** Se um elemento não muda de significado com a cor, é neutro.

---

## Componentes base

Vivem em `frontend/components/` (React + Tailwind 4; tokens em `frontend/app/globals.css`). Um ecrã compõe-se destes:

- `Button` — variantes: primary, secondary, ghost, danger
- `Input` / `Select` — com label, hint e erro
- `Card` — superfície com padding consistente
- `Badge` — estados e etiquetas (ok / erro / a converter)
- `Table` — cabeçalho, linhas, estado vazio; números à direita em Geist Mono
- `Dropzone` — upload multi-ficheiro (o componente específico deste produto)
- `EmptyState` — ícone, título, descrição, ação
- `Alert` — info, sucesso, aviso, erro

**Criar componente novo exige justificação.** Se algo aparece em dois ecrãs, é
componente. Se aparece num, é composição.

---

## Regras de composição

1. **Uma ação primária por ecrã.** As restantes são secundárias ou ghost.
2. **Largura máxima de texto:** ~70 caracteres. Conteúdo largo em `max-w-3xl`.
3. **Espaçamento vertical** entre secções: sempre o mesmo valor. Não afinar caso a caso.
4. **Alinhamento à esquerda** por defeito. Números alinhados à direita em tabelas.
5. **Nada de sombras** exceto em elementos flutuantes (modal, dropdown).

---

## Estados obrigatórios

Todo o ecrã que mostra dados tem de definir os quatro:

- **Vazio** — primeira utilização. Explica o que aparecerá aqui e dá a ação para começar.
- **A carregar** — skeleton, não spinner, quando a estrutura é conhecida.
- **Erro** — o que falhou, em linguagem humana, e o que fazer a seguir.
- **Cheio** — com muitos dados. Onde a paginação ou o scroll entram.

Um ecrã sem estado vazio definido não está desenhado.

---

## Acessibilidade — mínimos

- Contraste de texto ≥ 4.5:1 (≥ 3:1 para texto grande)
- Todos os controlos alcançáveis por teclado, com foco visível
- Ícone sozinho como ação leva sempre `aria-label`
- A informação nunca é transmitida só por cor

---

## Registo de alterações

Alterações ao sistema ficam aqui, com data e razão.

| Data | Alteração | Porquê |
|---|---|---|
| 2026-08-19 | Sistema inicial: Geist · `#7c3aed`/zinc · `0.75rem` · espaçosa | Decisões da entrevista de arranque (`/novo-projeto`) |
