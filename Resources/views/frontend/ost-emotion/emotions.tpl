
{* set namespace *}
{namespace name="frontend/ostEmotion/emotion"}



{* calculate placeholder dimensions *}
{$emotion = 0}
{$margin = 0}
{$height = 0}

{* loop basket emotion*}
{foreach $ostEmotions as $ostEmotion}

    {* even on top? *}
    {if $ostEmotion.position == $position}

        {* add to top *}
        {$emotion = $emotion + 1}
        {$margin = $margin + $ostEmotion.margin}
        {$height = $height + $ostEmotion.height}

    {/if}

{/foreach}

{* loop basket emotion*}
{foreach $ostEmotions as $ostEmotion}

    {* even on top? *}
    {if $ostEmotion.position == $position}

        {* output them *}
        <div class="emotion--wrapper ost-emotion--{$css}"
             data-controllerUrl="{url module='widgets' controller='emotion' action='index' emotionId=$ostEmotion.id}"
             data-availableDevices="{$ostEmotion.devices}">
        </div>

    {/if}

{/foreach}
