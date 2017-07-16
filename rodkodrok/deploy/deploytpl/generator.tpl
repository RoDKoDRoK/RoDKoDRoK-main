
{if isset($generatorconf) && is_array($generatorconf) && count($generatorconf) > 0 }
	{section name=cptgeneratorconf loop=$generatorconf}
		{include file=$generatorconf[cptgeneratorconf]}
	{/section}
{/if}

{include file="$chemintpltogenerate"}
