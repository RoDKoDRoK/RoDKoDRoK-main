
{$form.classicform__open}

{$form.hiddencodename}

{if isset($form.lineform) }
{section name=cptlineform loop=$form.lineform}
<div class="lineform">
	<div class="labelform">{$form.lineform[cptlineform].label}</div>
	<div class="champsform">{$form.lineform[cptlineform].champs}</div>
</div>
{/section}
{/if}


<div class="buttonzone">
{$form.deployconfirmbutton}
</div>

{$form.classicform__close}