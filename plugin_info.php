<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plugin_info
 *
 * @author kurozumi
 */
class plugin_info {
    /** プラグインコード(必須)：システム上でのキーとなります。プラグインコードは一意である必要があります。 */
    static $PLUGIN_CODE        = "AddParameter";
    /** プラグイン名(必須)：プラグイン管理・画面出力（エラーメッセージetc）にはこの値が出力されます。 */
    static $PLUGIN_NAME        = "パラメータ追加プラグイン";
    /** プラグインメインクラス名(必須)：本体がプラグインを実行する際に呼ばれるクラス。拡張子は不要です。 */
    static $CLASS_NAME         = "AddParameter";
    /** プラグインバージョン(必須) */
    static $PLUGIN_VERSION     = "0.1";
    /** 本体対応バージョン(必須) */
    static $COMPLIANT_VERSION  = "2.12.1から2.13.2";
    /** 作者(必須) */
    static $AUTHOR             = "kurozumi";
    /** 説明(必須) */
    static $DESCRIPTION        = "パラメータ設定のパラメータが追加できます。";
    /** 作者用のサイトURL：設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $AUTHOR_SITE_URL    = "";
    /** プラグインのサイトURL : 設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $PLUGIN_SITE_URL   = "";
    /** 使用するフックポイント：使用するフックポイントを設定すると、フックポイントが競合した際にアラートが出ます。 */
    static $HOOK_POINTS        = "LC_Page_Admin_System_Parameter_action_after";
    /** ライセンス */
    static $LICENSE        = "LGPL";
}