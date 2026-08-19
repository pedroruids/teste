# Briefings dos ecrãs — teste

Input para `/desenhar-ecra <nome>` (issues #3, #4, #5). Restrições visuais em `docs/DESIGN.md`; produto em `docs/PRODUTO.md`.

Comum aos três:
- **Shell:** cabeçalho fino com o nome do produto à esquerda e duas entradas de navegação (Converter · Histórico); conteúdo em `max-w-5xl` centrado; densidade espaçosa (8px base, secções separadas pelo mesmo espaçamento vertical).
- **Sem login, sem avatar, sem menu de conta.**
- **Números** (bytes, %, timestamps) sempre em Geist Mono, alinhados à direita em tabelas. Bytes em unidade humana (`1,8 MB`, `312 KB`); poupança em `−64 %` (sinal + percentagem inteira); WebP maior que o original em `+12 %` a `amber`, nunca escondido.
- **Estados de ficheiro** (Badge): `ok` (emerald) · `erro` (red) · `a converter` (zinc, com skeleton na linha).
- **Dados de exemplo realistas:** nomes de ficheiros de sites reais (`hero-homepage.jpg`, `equipa-2026.png`, `produto-cadeira-01.jpg`), tamanhos entre 150 KB e 6 MB, datas de Agosto 2026.

---

## 1. Converter — `docs/mockups/converter.html` (#3)

**Quem chega, de onde, para quê:** o Pedro, a abrir a app (é a página inicial `/`) com uma pasta de imagens exportadas para um site. Quer largá-las, carregar num botão e sacar os WebP. Zero configuração além da qualidade.

**Única acção primária:** **Converter** (brand-600). Tudo o resto secundário/ghost: limpar lista, remover um ficheiro, download ZIP, download individual.

**Dados mostrados**
- Antes de converter: lista dos ficheiros escolhidos — nome, tipo (JPG/PNG), tamanho original, botão remover (ícone com `aria-label`). Total: N ficheiros · X MB.
- Controlo de qualidade: slider ou input numérico 1–100, default **80**, com nota curta ("80 é o equilíbrio habitual para web").
- Depois de converter: a mesma lista ganha colunas depois / poupança / estado + link de download por linha; no topo um resumo do lote (N ok · M erro · antes → depois · −Y %) e o botão **Descarregar ZIP** (secundário).
- Opcional: pré-visualização em miniatura (thumbnail 40px) por linha — só se não pesar o layout.

**Regras de comportamento a mostrar no mockup**
- Aceita só JPG/PNG; ficheiro rejeitado no drop entra na lista já com estado `erro` e mensagem ("SVG não é suportado — só JPG e PNG"), sem bloquear os outros.
- Falha de conversão num ficheiro: linha em `erro` com motivo, o resto do lote `ok`, ZIP continua disponível (só os `ok`).
- WebP maior que o original: linha `ok` mas poupança a `amber` (+%), com nota "o original já estava optimizado".

**Os quatro estados**
1. **Vazio** — dropzone grande (tracejado zinc-200, raio `0.75rem`), ícone, "Arrasta imagens JPG ou PNG, ou escolhe ficheiros", qualidade visível mas Converter desactivado. Uma frase do que acontece a seguir ("Os WebP ficam aqui e no Histórico").
2. **A carregar** — lote a converter: barra de progresso do lote (3 de 12) + linhas com skeleton nas colunas depois/poupança; Converter desactivado; ordem dos ficheiros mantida.
3. **Erro** — dois sub-casos no mesmo bloco: (a) erro de rede/API ao enviar o lote — Alert `error` acima da lista com "Não foi possível enviar o lote — a API não respondeu. Tenta de novo." e botão **Tentar de novo**; (b) lote concluído com falhas parciais — resumo "9 ok · 3 erro" e linhas vermelhas com motivo.
4. **Cheio** — 24 ficheiros convertidos; onde o layout parte: nomes longos (`fotografia-da-equipa-no-evento-de-lancamento-2026-final-v3.jpg`) truncados com ellipsis + `title`; tabela com scroll interno ou altura limitada; resumo do lote fixo no topo.

**Composição sugerida:** coluna única. Bloco 1 dropzone (ou lista de ficheiros quando há ficheiros, com dropzone encolhida a uma barra "Adicionar mais"); bloco 2 qualidade + **Converter** alinhados à direita; bloco 3 resumo + tabela de resultados.

**Componentes:** `Dropzone` (novo, específico), `Button`, `Table`, `Badge`, `Alert`, `Input` (qualidade), `EmptyState` (não — o vazio é a própria dropzone).

---

## 2. Histórico — `docs/mockups/historico.html` (#4)

**Quem chega, de onde, para quê:** o Pedro, pela navegação, dias depois, à procura de um lote antigo ("as imagens do site X da semana passada") para re-descarregar ou ver quanto poupou.

**Única acção primária:** abrir um lote (a linha inteira é clicável → Detalhe). Não há botão primário visível; se for preciso um CTA, é **Converter** só no estado vazio.

**Dados mostrados** — tabela de lotes, mais recente primeiro:
- Data/hora (`19 ago 2026, 09:42`), nº ficheiros (`12 ficheiros` · com `2 erro` a vermelho quando houver), qualidade (`q80`), antes → depois (`18,4 MB → 6,1 MB`), poupança (`−67 %`), estado do lote (Badge: `concluído` · `com erros`), acção ghost "Descarregar ZIP" na linha (ícone + `aria-label`).
- Paginação: 15 por página, "1–15 de 48", anterior/seguinte.
- Opcional (não na v1): filtro por data, pesquisa por nome de ficheiro — **não desenhar**.

**Os quatro estados**
1. **Vazio** — `EmptyState`: ícone, "Ainda não converteste nada", "Cada lote que converteres fica aqui, com os tamanhos antes e depois e os ficheiros para re-descarregar.", botão **Converter imagens** (primário neste estado).
2. **A carregar** — skeleton de 6 linhas com as mesmas colunas, cabeçalho real.
3. **Erro** — Alert `error` no lugar da tabela: "Não foi possível carregar o histórico — a API não respondeu." + **Tentar de novo**.
4. **Cheio** — 15 linhas + paginação; testar linha com 1 ficheiro vs 120 ficheiros, poupança `−3 %` e `+8 %` (amber), lote só com erros (`0 ok · 5 erro`, badge `falhou`).

**Composição sugerida:** título "Histórico" + contagem total ("48 lotes") à esquerda; tabela em `Card`; paginação no rodapé do card, à direita.

**Componentes:** `Table`, `Badge`, `EmptyState`, `Alert`, `Button` (ghost nas linhas), paginação (pode ser composição de `Button` ghost, não componente novo).

---

## 3. Detalhe do lote — `docs/mockups/lote.html` (#5)

**Quem chega, de onde, para quê:** o Pedro, vindo do Histórico (ou do link logo após converter), para ver ficheiro a ficheiro, re-descarregar um ou todos, e perceber porque falhou algum — sem abrir `storage/logs`.

**Única acção primária:** **Descarregar ZIP** (brand-600) — é a razão de voltar a um lote. Downloads individuais são ghost por linha.

**Dados mostrados**
- Cabeçalho: "Lote #48" + data/hora; linha de metadados: qualidade `q80` · `12 ficheiros` · `10 ok · 2 erro` · `18,4 MB → 6,1 MB` · `−67 %`; Badge de estado do lote; breadcrumb/ligação "← Histórico".
- Tabela de ficheiros: nome original, tipo, antes, depois, poupança, estado, download (ghost, ícone + `aria-label`). Linhas `erro`: coluna depois/poupança vazias (`—`), mensagem do erro por baixo do nome em `zinc-500`/`red-600` ("Ficheiro corrompido — o GD não conseguiu ler a imagem").
- Secção **Log do lote** (abaixo da tabela, `Card` próprio): lista cronológica, um evento por linha: timestamp (Geist Mono, `09:42:03`) · tipo (Badge pequeno: `upload` · `ok` · `erro` · `download`) · texto ("hero-homepage.jpg convertido: 2,1 MB → 640 KB"). Colapsável? Não — visível por omissão; 12–40 linhas é normal.

**Os quatro estados** (aqui "vazio" não existe — um lote tem sempre ficheiros; substituir por "lote inexistente")
1. **Lote inexistente / apagado** — ecrã de erro com "Este lote não existe ou foi removido." + botão **Voltar ao Histórico**.
2. **A carregar** — cabeçalho com skeleton nos totais, tabela skeleton 6 linhas, log skeleton 4 linhas.
3. **Erro** — dois sub-casos: (a) falha de rede ao carregar (Alert + Tentar de novo); (b) **ficheiro já apagado do disco** (410): a linha fica com o download desactivado e nota "Ficheiro já não está disponível (retenção)"; ZIP continua se houver algum disponível, e o resumo diz "8 de 10 disponíveis".
4. **Cheio** — 120 ficheiros, 300 linhas de log: tabela com altura limitada e scroll interno ou paginação local; log com "mostrar mais"; nomes longos truncados.

**Composição sugerida:** cabeçalho (título + metadados à esquerda, **Descarregar ZIP** à direita) → `Card` tabela de ficheiros → `Card` Log do lote. Largura `max-w-5xl`.

**Componentes:** `Table`, `Badge`, `Alert`, `Button`, `Card`; o log é composição (lista), não componente novo — a menos que apareça noutro ecrã.

---

## Ordem sugerida
1. #2 sistema visual (componentes + `/design`) — opcional antes dos mockups; os mockups são HTML estático e podem vir primeiro.
2. `/desenhar-ecra converter` → `/desenhar-ecra historico` → `/desenhar-ecra lote`.
3. Rever os três lado a lado antes de fechar: mesma tabela de ficheiros no Converter e no Detalhe (mesmas colunas, mesma ordem) — se divergirem, uniformizar.
