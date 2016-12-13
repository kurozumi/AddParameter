<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
*}-->

<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->

<h2><!--{$tpl_subtitle}--></h2>
<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="regist">

<!--{if $arrErr}-->
	<p class="remark">
	<!--{foreach from=$arrErr item=error}-->
	<span class="attention"><!--{$error}--></span>
	<!--{/foreach}-->
	</p>
<!--{else}-->
	<p class="remark">定数名は英数の大文字を使用して下さい。また区切り文字としてアンダースコア(_)を使用して下さい。</p>
<!--{/if}-->

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
    <tr >
        <th bgcolor="#f3f3f3" style="width:20%;">定数名</th>
        <td>
			<input type="text" name="id" value="<!--{$arrForm.id|h}-->" class="box50" />
		</td>
	</tr>
	<tr>
        <th>パラメータ値</th>		
        <td>
			<input type="text" name="name" value="<!--{$arrForm.name|h}-->" class="box50" />
        </td>
	</tr>
		<th>コメント</th>
        <td>
			<input type="text" name="remarks" value="<!--{$arrForm.remarks|h}-->" class="box50" />
        </td>
    </tr>
    <tr >
    </tr>
</table>
		
<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="document.form1.submit();return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>

		
<h2>追加したパラメータ一覧</h2>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
    <tr >
        <th bgcolor="#f3f3f3">定数名</th>
        <th>削除</th>
    </tr>
<!--{section name=cnt loop=$arrKeys}-->
    <tr >
        <td bgcolor="#f3f3f3" width="20%"><!--{$arrKeys[cnt]|h}--></td>
        <td>
			 <a href="?" onclick="fnModeSubmit('delete', 'id', '<!--{$arrKeys[cnt]|h}-->'); return false;">削除</a>
        </td>
    </tr>
<!--{/section}-->
</table>

</form>

<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
