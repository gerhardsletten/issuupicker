{ezscript_require(array( 'ezjsc::jquery' , 'underscore-min.js' , 'issuupicker.js' ))}
{ezcss_require( array( 'issuupicker.css' ) )}
<div id="{$attribute.contentclassattribute_id}_{$attribute.contentclass_attribute_identifier}" class="issuu-preview">
	<div class="current-issuu" data-document-id="{$attribute.data_text|wash( xhtml )}"></div>
	<div class="issuu-finder">
		<div class="block">
			<label>Search issuu</label>
			<input type="text" class="issuu-search" />
		</div>
		<div class="issuu-search-preview"></div>
	</div>
<input id="ezcoa-{$attribute.contentclassattribute_id}_{$attribute.contentclass_attribute_identifier}"
       class="issuupicker ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}"
       type="hidden"
       name="{$attribute_base}_issuupicker_data_text_{$attribute.id}"
       value="{$attribute.data_text|wash( xhtml )}" />
</div>
<br /><br />