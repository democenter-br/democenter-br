/**
 * assets/js/i18n-common.js
 * ---------------------------------------------------------------------------
 * Dicionário de traduções em espanhol com as strings que se repetem
 * IDÊNTICAS em várias das páginas de demo do Democenter Netskope.
 * Partner edition: o PT-BR foi removido; este arquivo expõe apenas `es`.
 *
 * É carregado em TODAS as páginas "simples" do site (todas menos demos.php),
 * logo antes do script inline próprio de cada página, e é mesclado com o
 * dicionário específico dessa página assim:
 *
 *   const translations = {
 *       es: { ...NetskopeCommonI18n.es, "chave_propria_1": "...", ... }
 *   };
 *
 * O dicionário próprio de cada página vem DEPOIS no spread para poder
 * sobrescrever uma chave comum se algum dia for necessário (embora hoje essa
 * possibilidade não seja usada).
 *
 * O que foi incluído aqui (e o que não):
 * - As 3 chaves de navegação inferior "Quem é a Netskope? / Voltar à
 *   landing / Quer ver? 😉" apareciam, com o mesmo texto exato,
 *   em agenticai.php, aicontrol.php, vpnevolution.php, navigationevolution.php,
 *   dataprotection.php e networktransformation.php - mas cada página usava um
 *   nome de chave data-i18n diferente (btn.who / btn_who / btnWho, etc.). Elas
 *   foram unificadas aqui sob nomes canônicos (nav_who / nav_back / nav_demo) e
 *   os atributos data-i18n dessas 6 páginas foram atualizados para usá-los.
 * - O botão "Voltar para..." de oopsyoudidit.php NÃO foi incluído aqui porque seu
 *   texto é diferente ("Voltar a um lugar seguro" em vez de "Voltar à
 *   landing"): é conteúdo genuinamente específico dessa página.
 * - Os textos de rodapé (© ... Netskope. All rights reserved.) NÃO
 *   estão no sistema de i18n em nenhuma página (estão fixos no código em
 *   inglês igualmente nos 2 idiomas), então não havia nada a centralizar ali.
 * - Os "taglines" do header (p. ex. "SaaS e Navegação Segura", "Casos de
 *   Sucesso LATAM") são diferentes em cada página (identificam a página), por
 *   isso foram deixados como conteúdo específico de cada uma.
 * - keydifferentiators.php NÃO é mesclado com este arquivo: usa seu próprio
 *   catálogo carregado de assets/json/keydifferentiators.i18n.json (veja o
 *   comentário no início desse .php). Se no futuro se quiser compartilhar
 *   texto com essa página, é preciso sincronizar manualmente ambos os catálogos.
 *
 * Dúvida para revisar (flag para o Leo): as seções "O que dizem os
 * analistas" (market.title / analystSays / market_title / analyst_title,
 * presentes em agenticai/aicontrol/dataprotection/navigationevolution/
 * networktransformation/vpnevolution) têm, na maioria dos casos, um
 * sufixo diferente por página ("...sobre IA generativa", "...sobre Single
 * Vendor SASE", etc.), por isso NÃO foram centralizadas. Mas agenticai.php,
 * dataprotection.php e navigationevolution.php usam o título genérico
 * "O que dizem os analistas" sem sufixo — se for confirmado que deve ser
 * sempre igual nessas 3, poderia ser movido para cá em uma futura rodada.
 * ---------------------------------------------------------------------------
 */
const NetskopeCommonI18n = {
    es: {
        "nav_who": "Quem é a Netskope?",
        "nav_back": "Voltar à landing",
        "nav_demo": "Quer ver? 😉"
    }
};
