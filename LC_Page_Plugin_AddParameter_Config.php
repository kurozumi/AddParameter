<?php

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

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

class LC_Page_Plugin_AddParameter_Config extends LC_Page_Admin_Ex
{
    const PREFIX = "PLG_";

    /** 定数キーとなる配列 */
    public $arrKeys;
    public $arrForm = array();

    /**
     * 初期化する.
     *
     * @return void
     */
    function init()
    {
        parent::init();

        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . "AddParameter/templates/config.tpl";
        $this->tpl_subtitle = "パラメータ登録";

        $this->masterData = new SC_DB_MasterData_Ex();

        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode("AddParameter");

        if ($plugin["enable"] == 2) {
            $this->tpl_onload = "alert('プラグインを有効にして下さい。');";
            $this->tpl_onload .= 'window.close();';
        }

    }

    /**
     * プロセス.
     *
     * @return void
     */
    function process()
    {
        $this->action();
        $this->sendResponse();

    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action()
    {
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);
        $objFormParam->convParam();

        // 定数名
        $id = $objFormParam->getValue('id');

        $arrForm = array();
        $mode = $this->getMode();
        switch ($mode) {
            //　編集前
            case 'pre_edit':
                $arrForm = $this->getParam($id);
                // 定数名は編集させない
                $arrForm["pre_edit"] = true;
                $this->tpl_onload = 'document.form1.mode.value = "edit";';
                break;
            // 削除
            case 'delete':
                $this->delete($id);

                $this->tpl_onload = "alert('削除しました。');";
                $this->tpl_onload .= 'window.close();';
                break;
            // 登録・編集
            case 'regist':
            case 'edit':
                $arrForm = $objFormParam->getHashArray();

                $this->arrErr = $objFormParam->checkError();

                // エラーなしの場合にはデータを更新
                if (count($this->arrErr) == 0) {
                    switch ($mode) {
                        case 'regist':// データ挿入
                            $this->arrErr = $this->checkId($id);

                            // 定数名にエラーがない場合データを挿入
                            if (count($this->arrErr) == 0) {
                                $this->insert($arrForm);
                                $this->tpl_onload = "alert('登録が完了しました。');";
                                $this->tpl_onload .= 'window.close();';
                            }
                            break;
                        case 'edit': // データ編集
                            $this->update($arrForm);
                            $this->tpl_onload = "alert('更新が完了しました。');";
                            $this->tpl_onload .= 'window.close();';
                            break;
                    }
                }
                break;
            default:
                break;
        }

        $this->arrParams = $this->getParams();
        $this->arrForm = $arrForm;

        $this->setTemplate($this->tpl_mainpage);

    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy()
    {
        parent::destroy();

    }

    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @return void
     */
    function lfInitParam(&$objFormParam)
    {
        $objFormParam->addParam('定数名', 'id', STEXT_LEN, 'KVa', array('EXIST_CHECK', 'NO_SPTAB', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('コメント', 'remarks', STEXT_LEN, 'KVa');

    }

    /**
     * パラメーターを追加する.
     * 
     * @param type $arrForm
     */
    public function insert(&$arrForm)
    {
        // DBのデータを更新
        $this->masterData->insertMasterData('mtb_constants', $arrForm["id"], '""', $arrForm["remarks"]);

        // キャッシュを生成
        $this->masterData->createCache('mtb_constants', array(), true, array('id', 'remarks'));

    }

    /**
     * パラメーターを更新する.
     * 
     * @param type $arrForm
     */
    public function update(&$arrForm)
    {
        // DBのデータを更新
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        $objQuery->update("mtb_constants", $arrForm, "id=?", array($arrForm["id"]));

        // キャッシュを生成
        $this->masterData->createCache('mtb_constants', array(), true, array('id', 'remarks'));

    }

    /**
     * パラメータを削除する
     * 
     * @param type $arrForm
     */
    public function delete($id)
    {
        // DBのデータを更新
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        $objQuery->delete("mtb_constants", "id=?", array($id));

        // キャッシュを生成
        $this->masterData->createCache('mtb_constants', array(), true, array('id', 'remarks'));

    }

    /**
     * 
     * 
     * @param text $id
     * @return arry
     */
    public function getParam($id)
    {
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        return $objQuery->getRow('*', 'mtb_constants', 'id = ?', array($id));

    }

    /**
     * 登録したパラメータのリストを返す
     * 
     * @return array
     */
    public function getParams()
    {
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        return $objQuery->select('*', 'mtb_constants', 'id LIKE ?', array("PLG_%"));

    }

    /**
     * パラメーターのキーを配列で返す.
     *
     * @access private
     * @return array パラメーターのキーの配列
     */
    public function getParamKeys()
    {
        $keys = array();
        $i = 0;
        foreach ($this->masterData->getDBMasterData('mtb_constants') as $key => $val) {
            $keys[$i] = $key;
            $i++;
        }
        return $keys;

    }

    /**
     * 定数名チェック
     * 
     * @param type $id
     * @return array
     */
    public function checkId($id)
    {
        $arrErr = array();

        if (!preg_match("/^" . self::PREFIX . "/", $id)) {
            $arrErr["id"] = sprintf("※ 定数名の先頭には「%s」を付けて下さい。", self::PREFIX);
        }

        foreach (explode("_", $id) as $str) {
            if (!ctype_upper($str))
                $arrErr["id"] = "※ 定数名は英数の大文字を使用して下さい。また区切り文字としてアンダースコア(_)を使用して下さい。";
        }

        $constants = $this->getParamKeys();

        if (in_array($id, $constants)) {
            $arrErr["id"] = sprintf("※ 定数名「%s」は定義済みです。", $id);
        }

        return $arrErr;

    }

}
