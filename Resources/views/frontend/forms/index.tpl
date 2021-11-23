
{* file to extend *}
{extends file="parent:frontend/forms/index.tpl"}

{* set namespace *}
{namespace name="frontend/ostEmotion/forms"}



{* on top of forms *}
{block name='frontend_forms_elements_error'}
    {if is_array($ostEmotions) && count($ostEmotions) > 0}
        {include file="frontend/ost-emotion/emotions.tpl" css="forms-top" position="1"}
    {/if}

    {* parent smarty block *}
    {$smarty.block.parent}

{/block}



{* below forms *}
{block name='frontend_forms_index_content'}

    {* parent smarty block *}
    {$smarty.block.parent}

    {* ... *}
    {if is_array($ostEmotions) && count($ostEmotions) > 0}
        {include file="frontend/ost-emotion/emotions.tpl" css="forms-bottom" position="2"}
    {/if}

{/block}
