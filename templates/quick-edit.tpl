<div class="quick-edit">
  <h3>Quick Edit - {$title}</h3>
  <form method="post" enctype="multipart/form-data" action="actions/quick-edit.php?arg1={$table}&arg2={$id}&arg3={$field}" target="frajax-iframe">
    <div>
    {$control}
    </div>
    <br />
    <input type="submit" name="btn_save" value="Save" title="Save the changes" />
    <input type="submit" name="btn_menu" value="Menu" onclick="frajax('quick-edit', '{$table}', '{$id}'); return false;" />
  </form>
</div>