<h3>Quick Edit Menu</h3>
<p>A quick and easy way to make small updates to page content</p>
<ul>
{section name=o loop=$options}
<li><a href="{$ADMIN}/edit/{$table}/{$id}/" onclick="frajax('quick-edit', '{$table}', '{$id}', '{$options[o].field}'); return false;">{$options[o].name}</a></li>
{/section}
</ul>
<button onclick="window.location = window.location;">Exit Quick Edit</button>{** refreshes the page **}
<button onclick="window.location = '{$ADMIN}/edit/{$table}/{$id}/';">Full Editor</button>
<hr />
<p>The quick edit functionality is experimental. We would love to know how you find it, please email <a href="mailto:info@jojocms.org">info@jojocms.org</a> with comments and suggestions.</p>