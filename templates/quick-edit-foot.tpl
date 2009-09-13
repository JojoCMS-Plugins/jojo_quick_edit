{if $showquickedit && !$isadmin}
<div id="quick-edit-button" title="Quick edit menu - {$qt} ID:{$qid}"><a id="quick-edit-link" href="edit/{$qt}/{$qid}/" onclick="return frajax('quick-edit','{$qt}','{$qid}');"><img src="images/cms/admin/quickedit.png" alt="" /></a></div>
{/if}