<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }

define ('CMTX_HINT_SEND', 'Enviar um e-mail de notificação deste comentário para assinantes.');
define ('CMTX_HINT_STICKY', 'Cole este comentário no topo.');
define ('CMTX_HINT_LOCKED', 'Bloquear respostas para este comentário.');

define ('CMTX_HINT_NEWEST_FIRST', 'Lista os comentários por ordem do mais velho ou mais novo os primeiro.');
define ('CMTX_HINT_DISPLAY_SAYS', 'Mostrar a palavra <i>diz</i> após o nome do usuário.');
define ('CMTX_HINT_JS_VOTE_OK', 'Exibir uma mensagem JavaScript se o voto de Curtir / Não Curtir estiver ok.');

define ('CMTX_HINT_PAGINATION_ENABLED', 'Devem ser distribuídos os comentários através de várias páginas?');
define ('CMTX_HINT_PAGINATION_TOP', 'Exibir os links de paginação acima da área de comentários.');
define ('CMTX_HINT_PAGINATION_BOTTOM', 'Exibir os links de paginação abaixo da área de comentários.');
define ('CMTX_HINT_PAGINATION_PER_PAGE', 'Quantos comentários se deve exibir por página.');
define ('CMTX_HINT_PAGINATION_RANGE', 'A quantidade de links para exibir em cada lado da página atual.');

define ('CMTX_HINT_SORT_BY_ENABLED', 'Exibir o Sort By links.');
define ('CMTX_HINT_SORT_BY_1', 'Para que isso funcione a data também deve ser habilitado.');
define ('CMTX_HINT_SORT_BY_2', 'Para que isso funcione a data também deve ser habilitado.');
define ('CMTX_HINT_SORT_BY_3', 'Para que isso funcione o recurso Like também deve ser habilitado.');
define ('CMTX_HINT_SORT_BY_4', 'Para que isso funcione o recurso Dislike também deve ser habilitado.');
define ('CMTX_HINT_SORT_BY_5', 'Para que isso funcione o recurso de Rating também deve ser habilitado.');
define ('CMTX_HINT_SORT_BY_6', 'Para que isso funcione o recurso de Rating também deve ser habilitado.');

define ('CMTX_HINT_SHOW_REPLY', 'Exibir o link para resposta dentro da caixa de comentário.');
define ('CMTX_HINT_REPLY_DEPTH', 'Quantos níveis de resposta antes do link de resposta ser desabilitado. Entre um número de 1 ou acima. Tenha certeza que a largura das respostas podem se encaixar na sua página.');
define ('CMTX_HINT_REPLY_ARROW', 'Se deseja exibir uma seta ao lado das respostas.');
define ('CMTX_HINT_SCROLL_REPLY', 'Gradualmente rolar para baixo o formulário depois de clicar no link de resposta.');

define ('CMTX_HINT_SOCIAL_ENABLED', 'Exibir os links de compartilhamento social.');

define ('CMTX_HINT_GRAVATAR_DEFAULT', 'Deixe em branco para o padrão atual.');
define ('CMTX_HINT_GRAVATAR_RATING', 'O tipo de público. G é apropriado para todas as audiências.');

define ('CMTX_HINT_DISPLAY_JS_MSG', 'Exibir uma mensagem de aviso se o Javascript está desabilitado no navegador do usuário.');
define ('CMTX_HINT_DISPLAY_AST_SYMBOL', 'Exibir o símbolo de asterisco (*) próximo aos campos requeridos.');
define ('CMTX_HINT_DISPLAY_AST_MSG', 'Exibir a mensagem de asterisco:<br/>* Informação requerida');
define ('CMTX_HINT_DISPLAY_EMAIL_NOTE', 'Exibir a mensagem de email:<br/> (não será publicado)');
define ('CMTX_HINT_REPEAT_RATINGS', 'O que fazer com o campo de avaliação uma vez que o usuário já tenha avaliado.');
define ('CMTX_HINT_AGREE_TO_PREVIEW', 'Deve o usuário ter que aceitar a política de privacidade e os termos e condições antes de ser capaz de visualizar o comentário?');

define ('CMTX_HINT_APPROVE_COMMENTS', 'Manualmente aprovar todos os comentários.');
define ('CMTX_HINT_APPROVE_NOTIFICATIONS', 'Manualmente aprovar todos emails de notificação de inscrição.');

define ('CMTX_HINT_FLAG_MAX_PER_USER', 'O máximo número de relatos pendentes que um usuário pode submeter.');
define ('CMTX_HINT_FLAG_MIN_PER_COM', 'O mínimo número de relatos pendentes antes de um comentário ser marcado.');
define ('CMTX_HINT_FLAG_DISAPPROVE', 'Deve um comentário marcado ser rejeitado?');

define ('CMTX_HINT_ONE_NAME', 'Rejeitar comentários se mais de um nome for digitado.');
define ('CMTX_HINT_FIX_NAME', 'Capitalizar a primeira letra.<br />As demais letras em minúsculas.');

define ('CMTX_HINT_FIX_TOWN', 'Capitalizar a primeira letra.<br />As demais letras em minúsculas.');

define ('CMTX_HINT_APPROVE_WEBSITE', 'Manualmente aprovar o comentário se o usuário digitar um endereço de website no campo Website.');
define ('CMTX_HINT_PING', 'Verifica se o site existe. Seu servidor tem que ser capaz de fazer isto.');
define ('CMTX_HINT_NEW_WIN', 'Abrir link(s) em uma nova janela (tab).');
define ('CMTX_HINT_NO_FOLLOW', 'Adicionar a tag <i>rel=nofollow</i> para links para impedir que mecanismos de busca de seguí-los. Isto é bom para SEO (otimização de mecanismo de busca).');
define ('CMTX_HINT_CONVERT_LINKS', 'Fazer todos os endereços da web que forem digitados clicáveis.');
define ('CMTX_HINT_CONVERT_EMAILS', 'Fazer todos os endereços de email que forem digitados clicáveis.');
define ('CMTX_HINT_LINE_BREAKS', 'Respeitar quando o usuário pressionar a tecla Enter para iniciar uma nova linha.');
define ('CMTX_HINT_MASK', 'Trocar qualquer palavrão encontrado por este pedaço de texto.');
define ('CMTX_HINT_MAX_CAPITALS', 'Detectar quando um usuário digitar uma alta procentagem de letras maiúsculas.');
define ('CMTX_HINT_DETECT_REPEATS', 'Detectar quando um usuário entra com 3 ou mais caracteres repetidos.');

define ('CMTX_HINT_BAN_COOKIE', 'A quantidade de dias antes de expirar o cookie proibição.');
define ('CMTX_HINT_CHECK_REFERRER', 'Quer para verificar se o formulário foi enviado a partir do seu próprio site.');
define ('CMTX_HINT_CHECK_DB_FILE', 'Quer para verificar se o banco de dados arquivo de detalhes, includes/db/details.php, é somente leitura.');
define ('CMTX_HINT_SECURITY_KEY', 'A chave de segurança é adicionada ao formulário como um campo oculto. A chave é única para cada instalação. Normalmente não há necessidade para alterar isto.');

define ('CMTX_HINT_ADMIN_FOLDER', 'O nome de sua pasta administrativa renomeada.');
define ('CMTX_HINT_TIME_ZONE', 'O fuso horário de sua localização.');
define ('CMTX_HINT_COMMENTS_URL', 'A URL absoluta de sua pasta de comentários.');
define ('CMTX_HINT_MYSQL_DUMP', 'Se você está tendo problemas com a ferramenta de backup de base de dados, você talvez precise especificar o caminho do servidor para o seu arquivo MySQLDump.');
define ('CMTX_HINT_WYSIWYG', 'Deve o editor HTML WYSIWYG (What You See Is What You Get - O Que Você Vê É O Que Você Tem) ser habilitado para a página de Edição de Comentários?');
define ('CMTX_HINT_LIMIT_COMMENTS', 'Para melhorar o desempenho, mostram apenas esta quantidade de resultados em Manage -> Comments.');

define ('CMTX_HINT_VISITOR_ENABLED', 'Se a atividade do visitante deve ser monitorado e gravado.');
define ('CMTX_HINT_VISITOR_TIMEOUT', 'A quantidade de tempo antes de um visualizador on-line é considerado inativo e, portanto, não visualizando a página.');
define ('CMTX_HINT_VISITOR_REFRESH', 'Se deseja atualizar automaticamente a página Tools -> Viewers.');
define ('CMTX_HINT_VISITOR_INTERVAL', 'Quantas vezes para atualizar a página Tools -> Viewers.');

?>