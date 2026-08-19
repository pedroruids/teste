# teste — conversor de imagens para WebP

## O problema
Preparar imagens para sites (JPG/PNG → WebP optimizado) é feito hoje no Squoosh,
no browser, **uma imagem de cada vez**. É repetitivo (as mesmas definições a cada
ficheiro), lento em lotes, e **não deixa histórico** — não há registo do que foi
convertido, com que qualidade, nem quanto se poupou.

## Para quem
O Pedro, a preparar as imagens dos sites que constrói. Um único utilizador,
em máquina local. Sem equipa, sem clientes, sem contas.

## A hipótese
Acreditamos que uma mini plataforma local, que aceita um lote de imagens, as
converte para WebP com uma qualidade escolhida e guarda o histórico de cada
conversão, substitui o Squoosh no dia-a-dia.
Saberemos que estávamos certos se, ao fim de um mês, as imagens dos sites novos
passaram todas por aqui e o Squoosh deixou de ser aberto.

## O que NÃO é
1. **Não é multi-utilizador nem tem registo/login** — só o Pedro, só local.
2. **Não é editor de imagem** — sem crop, resize manual, filtros ou texto. Só conversão + optimização.
3. **Não é CDN nem aloja imagens para produção** — converte e dá o download; os sites não a referenciam por URL.
4. **Não integra com WordPress/CMS nem expõe API pública** — sem plugin, sem endpoints para terceiros.
5. **Não converte vídeo nem produz outros formatos de saída** (AVIF, PNG, JPG) — entrada imagem → saída WebP, e só.

## Primeira versão utilizável
- Upload de **várias imagens de uma vez** (JPG/PNG), qualidade WebP à escolha (default 80), converter, **download em ZIP** ou uma a uma.
- **Histórico** de conversões: cada lote com data, ficheiros, tamanho antes/depois, % poupado e re-download.
- **Log de tudo** (uploads, conversões OK/erro, downloads) — visível no detalhe do lote e em ficheiro (`storage/logs`).
- Falha num ficheiro **não pára o lote** — os restantes continuam e a falha fica registada.

## Fluxos principais

### F1 — Converter um lote
- **Quem:** o Pedro · **Quer:** WebP optimizados de N imagens
- **Passos:** abrir Converter → arrastar/seleccionar JPG/PNG (vários) → escolher qualidade (default 80) → "Converter" → ver resultado por ficheiro (antes / depois / %) → descarregar ZIP ou individual.
- **Pode correr mal:** ficheiro não suportado (HEIC, SVG, PDF) · ficheiro demasiado grande · upload interrompido · conversão falha num ficheiro (os outros continuam) · WebP fica maior que o original (avisar).

### F2 — Consultar histórico
- **Quem:** o Pedro · **Quer:** encontrar uma conversão anterior e re-descarregar
- **Passos:** abrir Histórico → lista de lotes por data (nº ficheiros, poupança total) → abrir lote → detalhe por ficheiro → re-download.
- **Pode correr mal:** ficheiros já apagados do disco (retenção) · lista cresce sem fim (paginação).

### F3 — Ver o log
- **Quem:** o Pedro · **Quer:** perceber o que aconteceu, sobretudo erros
- **Passos:** entradas de log por evento (upload, conversão OK/erro, download) no detalhe do lote + ficheiro em `storage/logs`.
- **Pode correr mal:** log ilegível / demasiado ruído.

## Ecrãs
1. **Converter** — dropzone multi-ficheiro, qualidade, botão Converter, resultados do lote, download ZIP/individual.
2. **Histórico** — lista de lotes (data, nº ficheiros, antes/depois, % poupado), paginada.
3. **Detalhe do lote** — ficheiros do lote com tamanhos, estado (ok/erro), re-download, log do lote.

Sem login. A UI vive no Next.js (`frontend/`).

## Entidades
- **Conversion** — o lote: data, qualidade, nº ficheiros, bytes antes/depois, estado.
- **ConversionFile** — cada ficheiro: nome original, caminho do original e do WebP, bytes antes/depois, estado (ok/erro), mensagem de erro.
- **Log** — eventos (upload, conversão, erro, download); decidir na Fase F se é tabela própria ligada ao lote ou só `storage/logs` com o id do lote no contexto.

Modelo detalhado em `docs/ARCHITECTURE.md` (Fase F, depois dos ecrãs).
