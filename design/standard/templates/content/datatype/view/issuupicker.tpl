{if is_unset($width)}
	{def $width = 420}
{/if}
{if is_unset($height)}
	{def $height = 251}
{/if}
<object style="width:{$width}px;height:{$height}px" ><param name="movie" value="http://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf?mode=mini&amp;embedBackground=%23000000&amp;backgroundColor=%23222222&amp;documentId={$attribute.data_text|wash( xhtml )}" /><param name="allowfullscreen" value="true"/><param name="menu" value="false"/><param name="wmode" value="transparent"/><embed src="http://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf" type="application/x-shockwave-flash" allowfullscreen="true" menu="false" wmode="transparent" style="width:{$width}px;height:{$height}px" flashvars="mode=mini&amp;embedBackground=%23000000&amp;backgroundColor=%23222222&amp;documentId={$attribute.data_text|wash( xhtml )}" /></object>