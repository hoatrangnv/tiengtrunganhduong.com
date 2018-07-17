<?php
namespace console\controllers;

use backend\models\ChineseSingleWord;
use yii\console\Controller;
use backend\models\NameTranslation;

class ImportController extends Controller {
//    public function actionNameTranslation()
//    {
//        json_encode([], JSON_UNESCAPED_SLASHES| JSON_UNESCAPED_UNICODE);
//
//        $json = '[{"name":"\u00c1","trans":"\u4e9a","spell":"Y\u00e0"},{"name":"\u00c1I","trans":"\u7231","spell":"\u00c0i"},{"name":"AN","trans":"\u5b89","spell":"An"},{"name":"\u00c2N","trans":"\u6069","spell":"\u0112n\u00a0"},{"name":"\u1ea8N","trans":"\u9690","spell":"Y\u01d0n\u00a0"},{"name":"\u1ea4N","trans":"\u5370","spell":"Y\u00ecn\u00a0"},{"name":"ANH","trans":"\u82f1","spell":"Y\u012bng\u00a0"},{"name":"\u00c1NH","trans":"\u6620","spell":"Y\u00ecng"},{"name":"\u1ea2NH","trans":"\u5f71","spell":"Y\u01d0ng"},{"name":"BA","trans":"\u6ce2","spell":"B\u014d\u00a0"},{"name":"B\u00c1","trans":"\u4f2f","spell":"B\u00f3"},{"name":"B\u1eaeC","trans":"\u5317","spell":"B\u011bi\u00a0"},{"name":"B\u00c1CH","trans":"\u767e","spell":"B\u01cei\u00a0"},{"name":"B\u1ea0CH","trans":"\u767d","spell":"B\u00e1i"},{"name":"BAN","trans":"\u73ed","spell":"B\u0101n"},{"name":"B\u1ea2N","trans":"\u672c","spell":"B\u011bn"},{"name":"B\u0102NG","trans":"\u51b0","spell":"B\u012bng"},{"name":"B\u1eb0NG","trans":"\u51af","spell":"F\u00e9ng\u00a0"},{"name":"B\u1ea2O","trans":"\u5b9d","spell":"B\u01ceo\u00a0"},{"name":"B\u00c1T","trans":"\u516b","spell":"B\u0101"},{"name":"B\u1ea2Y","trans":"\u4e03","spell":"Q\u012b"},{"name":"B\u00c9","trans":"\u9589","spell":"B\u00ec\u00a0"},{"name":"B\u00cdCH","trans":"\u78a7","spell":"B\u00ec\u00a0"},{"name":"BI\u00caN","trans":"\u8fb9","spell":"Bi\u0101n\u00a0"},{"name":"BINH","trans":"\u5175","spell":"B\u012bng"},{"name":"B\u00cdNH","trans":"\u67c4","spell":"B\u01d0ng\u00a0"},{"name":"B\u00ccNH","trans":"\u5e73","spell":"P\u00edng\u00a0"},{"name":"B\u1ed0I","trans":"\u8d1d","spell":"B\u00e8i\u00a0"},{"name":"B\u1ed8I","trans":"\u80cc","spell":"B\u00e8i"},{"name":"B\u00d9I","trans":"\u88f4","spell":"P\u00e9i"},{"name":"B\u1eecU","trans":"\u5b9d","spell":"B\u01ceo"},{"name":"CA","trans":"\u6b4c","spell":"G\u0113"},{"name":"C\u1ea6M","trans":"\u7434","spell":"Q\u00edn"},{"name":"C\u1ea8M","trans":"\u9526","spell":"J\u01d0n"},{"name":"C\u1eacN","trans":"\u8fd1","spell":"J\u00ecn"},{"name":"C\u1ea2NH","trans":"\u666f","spell":"J\u01d0ng\u00a0"},{"name":"CAO","trans":"\u9ad8","spell":"G\u0101o\u00a0"},{"name":"C\u00c1T","trans":"\u5409","spell":"J\u00ed"},{"name":"C\u1ea6U","trans":"\u7403","spell":"Qi\u00fa"},{"name":"CH\u1ea4N","trans":"\u9707","spell":"Zh\u00e8n"},{"name":"CH\u00c1NH","trans":"\u6b63","spell":"Zh\u00e8ng\u00a0"},{"name":"CH\u00c2U","trans":"\u6731","spell":"Zh\u016b\u00a0"},{"name":"CHI","trans":"\u829d","spell":"Zh\u012b\u00a0"},{"name":"CH\u00cd\u00a0","trans":"\u5fd7","spell":"Zh\u00ec\u00a0"},{"name":"CHI\u1ebeN","trans":"\u6218","spell":"Zh\u00e0n\u00a0"},{"name":"CHI\u1ec2U","trans":"\u6cbc","spell":"Zh\u01ceo"},{"name":"CHINH","trans":"\u5f81","spell":"Zh\u0113ng\u00a0"},{"name":"CH\u00cdNH","trans":"\u6b63","spell":"Zh\u00e8ng\u00a0"},{"name":"CH\u1ec8NH","trans":"\u6574","spell":"Zh\u011bng"},{"name":"CHU","trans":"\u73e0","spell":"Zh\u016b"},{"name":"CH\u01af","trans":"\u8bf8","spell":"Zh\u016b"},{"name":"CHU\u1ea8N","trans":"\u51c6","spell":"Zh\u01d4n"},{"name":"CH\u00daC","trans":"\u795d","spell":"Zh\u00f9"},{"name":"CHUNG","trans":"\u7ec8","spell":"Zh\u014dng\u00a0"},{"name":"CH\u00daNG","trans":"\u4f17","spell":"Zh\u00f2ng\u00a0"},{"name":"CH\u01afNG","trans":"\u5f81","spell":"Zh\u0113ng"},{"name":"CH\u01af\u01a0NG","trans":"\u7ae0","spell":"Zh\u0101ng"},{"name":"CH\u01af\u1edeNG","trans":"\u638c","spell":"Zh\u01ceng"},{"name":"CHUY\u00caN","trans":"\u4e13","spell":"Zhu\u0101n"},{"name":"C\u00d4N","trans":"\u6606","spell":"K\u016bn"},{"name":"C\u00d4NG","trans":"\u516c","spell":"G\u014dng\u00a0"},{"name":"C\u1eea","trans":"\u68d2","spell":"B\u00e0ng"},{"name":"C\u00daC","trans":"\u83ca","spell":"J\u00fa"},{"name":"CUNG","trans":"\u5de5","spell":"G\u014dng\u00a0"},{"name":"C\u01af\u01a0NG","trans":"\u7586","spell":"Ji\u0101ng"},{"name":"C\u01af\u1edcNG","trans":"\u5f3a","spell":"Qi\u00e1ng\u00a0"},{"name":"C\u1eecU","trans":"\u4e5d","spell":"Ji\u01d4\u00a0"},{"name":"D\u1ea0","trans":"\u591c","spell":"Y\u00e8"},{"name":"\u0110\u1eaeC","trans":"\u5f97","spell":"De\u00a0"},{"name":"\u0110\u1ea0I","trans":"\u5927","spell":"D\u00e0\u00a0"},{"name":"\u0110AM","trans":"\u62c5","spell":"D\u0101n"},{"name":"\u0110\u00c0M","trans":"\u8c08","spell":"T\u00e1n\u00a0"},{"name":"\u0110\u1ea2M","trans":"\u62c5","spell":"D\u0101n\u00a0"},{"name":"\u0110\u1ea0M","trans":"\u6de1","spell":"D\u00e0n\u00a0"},{"name":"D\u00c2N","trans":"\u6c11","spell":"M\u00edn"},{"name":"D\u1ea6N","trans":"\u5bc5","spell":"Y\u00edn"},{"name":"\u0110AN","trans":"\u4e39","spell":"D\u0101n\u00a0"},{"name":"\u0110\u0102NG","trans":"\u767b","spell":"D\u0113ng\u00a0"},{"name":"\u0110\u0102NG","trans":"\u706f","spell":"D\u0113ng\u00a0"},{"name":"\u0110\u1ea2NG","trans":"\u515a","spell":"D\u01ceng"},{"name":"\u0110\u1eb2NG","trans":"\u7b49","spell":"D\u011bng"},{"name":"\u0110\u1eb6NG","trans":"\u9093","spell":"D\u00e8ng\u00a0"},{"name":"DANH","trans":"\u540d","spell":"M\u00edng"},{"name":"\u0110\u00c0O","trans":"\u6843","spell":"T\u00e1o\u00a0"},{"name":"\u0110\u1ea2O","trans":"\u5c9b","spell":"D\u01ceo"},{"name":"\u0110\u1ea0O","trans":"\u9053","spell":"D\u00e0o"},{"name":"\u0110\u1ea0T","trans":"\u8fbe\u00a0","spell":"D\u00e1"},{"name":"D\u1eacU","trans":"\u9149","spell":"Y\u01d2u"},{"name":"\u0110\u1ea4U","trans":"\u6597","spell":"D\u00f2u"},{"name":"\u0110\u00cdCH","trans":"\u5ae1","spell":"D\u00ed\u00a0"},{"name":"\u0110\u1ecaCH","trans":"\u72c4","spell":"D\u00ed\u00a0"},{"name":"DI\u1ec4M","trans":"\u8273","spell":"Y\u00e0n"},{"name":"\u0110I\u1ec0M","trans":"\u606c","spell":"Ti\u00e1n"},{"name":"\u0110I\u1ec2M","trans":"\u70b9","spell":"Di\u01cen"},{"name":"DI\u1ec4N","trans":"\u6f14","spell":"Y\u01cen"},{"name":"DI\u1ec6N","trans":"\u9762","spell":"Mi\u00e0n"},{"name":"\u0110I\u1ec0N","trans":"\u7530","spell":"Ti\u00e1n\u00a0"},{"name":"\u0110I\u1ec2N","trans":"\u5178","spell":"Di\u01cen"},{"name":"\u0110I\u1ec6N","trans":"\u7535","spell":"Di\u00e0n\u00a0"},{"name":"DI\u1ec6P","trans":"\u53f6","spell":"Y\u00e8\u00a0"},{"name":"\u0110I\u1ec6P","trans":"\u8776","spell":"Di\u00e9\u00a0"},{"name":"DI\u1ec6U","trans":"\u5999","spell":"\u00a0Mi\u00e0o\u00a0"},{"name":"\u0110I\u1ec0U","trans":"\u6761","spell":"Ti\u00e1o"},{"name":"DINH","trans":"\u8425","spell":"Y\u00edng"},{"name":"\u0110INH","trans":"\u4e01","spell":"D\u012bng"},{"name":"\u0110\u00cdNH","trans":"\u8ba2","spell":"D\u00ecng"},{"name":"\u0110\u00ccNH","trans":"\u5ead","spell":"T\u00edng"},{"name":"\u0110\u1ecaNH","trans":"\u5b9a","spell":"D\u00ecng\u00a0"},{"name":"D\u1ecaU","trans":"\u67d4","spell":"R\u00f3u"},{"name":"\u0110\u00d4","trans":"\u90fd","spell":"D\u014du\u00a0"},{"name":"\u0110\u1ed6","trans":"\u675c","spell":"D\u00f9"},{"name":"\u0110\u1ed8","trans":"\u5ea6","spell":"D\u00f9"},{"name":"\u0110O\u00c0I","trans":"\u5151","spell":"Du\u00ec"},{"name":"DO\u00c3N","trans":"\u5c39","spell":"Y\u01d0n"},{"name":"\u0110OAN","trans":"\u7aef","spell":"Du\u0101n"},{"name":"\u0110O\u00c0N","trans":"\u56e2","spell":"Tu\u00e1n"},{"name":"DOANH","trans":"\u5b34","spell":"Y\u00edng\u00a0"},{"name":"\u0110\u00d4N","trans":"\u60c7","spell":"D\u016bn"},{"name":"\u0110\u00d4NG","trans":"\u4e1c","spell":"D\u014dng"},{"name":"\u0110\u1ed2NG","trans":"\u4edd","spell":"T\u00f3ng\u00a0"},{"name":"\u0110\u1ed8NG","trans":"\u6d1e","spell":"D\u00f2ng"},{"name":"DU","trans":"\u6e38","spell":"Y\u00f3u"},{"name":"D\u01af","trans":"\u4f59","spell":"Y\u00fa"},{"name":"D\u1ef0","trans":"\u5401","spell":"X\u016b\u00a0"},{"name":"D\u1ee4C","trans":"\u80b2","spell":"Y\u00f9\u00a0"},{"name":"\u0110\u1ee8C","trans":"\u5fb7","spell":"D\u00e9\u00a0"},{"name":"DUNG","trans":"\u84c9","spell":"R\u00f3ng\u00a0"},{"name":"D\u0168NG","trans":"\u52c7","spell":"Y\u01d2ng\u00a0"},{"name":"D\u1ee4NG","trans":"\u7528","spell":"Y\u00f2ng"},{"name":"\u0110\u01af\u1ee2C","trans":"\u5f97","spell":"De"},{"name":"D\u01af\u01a0NG","trans":"\u7f8a","spell":"Y\u00e1ng\u00a0"},{"name":"D\u01af\u1ee0NG","trans":"\u517b","spell":"Y\u01ceng"},{"name":"\u0110\u01af\u1edcNG","trans":"\u5510","spell":"T\u00e1ng"},{"name":"D\u01af\u01a0NG\u00a0","trans":"\u6768","spell":"Y\u00e1ng"},{"name":"DUY","trans":"\u7ef4","spell":"W\u00e9i\u00a0"},{"name":"DUY\u00caN","trans":"\u7f18","spell":"Yu\u00e1n\u00a0"},{"name":"DUY\u1ec6T","trans":"\u9605","spell":"Yu\u00e8"},{"name":"G\u1ea4M","trans":"\u9326","spell":"J\u01d0n\u00a0"},{"name":"GIA","trans":"\u5609","spell":"Ji\u0101\u00a0"},{"name":"GIANG","trans":"\u6c5f\u00a0","spell":"Ji\u0101ng\u00a0"},{"name":"GIAO","trans":"\u4ea4","spell":"Ji\u0101o\u00a0"},{"name":"GI\u00c1P","trans":"\u7532","spell":"Ji\u01ce\u00a0"},{"name":"GI\u1edaI","trans":"\u754c","spell":"Ji\u00e8"},{"name":"H\u00c0","trans":"\u4f55","spell":"H\u00e9\u00a0"},{"name":"H\u1ea0","trans":"\u590f","spell":"Xi\u00e0\u00a0"},{"name":"H\u1ea2I","trans":"\u6d77","spell":"H\u01cei\u00a0"},{"name":"H\u00c1N","trans":"\u6c49","spell":"H\u00e0n"},{"name":"H\u00c0N","trans":"\u97e9","spell":"H\u00e1n\u00a0"},{"name":"H\u00c2N","trans":"\u6b23","spell":"X\u012bn\u00a0"},{"name":"H\u1eb0NG","trans":"\u59ee\u00a0","spell":"H\u00e9ng"},{"name":"H\u00c0NH","trans":"\u884c","spell":"X\u00edng"},{"name":"H\u1ea0NH","trans":"\u884c","spell":"X\u00edng"},{"name":"H\u00c0O","trans":"\u8c6a","spell":"H\u00e1o\u00a0"},{"name":"H\u1ea2O","trans":"\u597d","spell":"H\u01ceo\u00a0"},{"name":"H\u1ea0O","trans":"\u660a","spell":"H\u00e0o"},{"name":"H\u1eacU","trans":"\u540e","spell":"H\u00f2u\u00a0"},{"name":"HI\u00caN","trans":"\u8431","spell":"Xu\u0101n\u00a0"},{"name":"HI\u1ebeN","trans":"\u732e","spell":"Xi\u00e0n"},{"name":"HI\u1ec0N","trans":"\u8d24","spell":"Xi\u00e1n\u00a0"},{"name":"HI\u1ec2N","trans":"\u663e","spell":"Xi\u01cen\u00a0"},{"name":"HI\u1ec6N","trans":"\u73b0","spell":"Xi\u00e0n\u00a0"},{"name":"HI\u1ec6P","trans":"\u4fa0","spell":"Xi\u00e1\u00a0"},{"name":"HI\u1ebeU","trans":"\u5b5d","spell":"Xi\u00e0o\u00a0"},{"name":"HI\u1ec2U","trans":"\u5b5d","spell":"Xi\u00e0o"},{"name":"HI\u1ec6U","trans":"\u6821","spell":"Xi\u00e0o"},{"name":"HINH","trans":"\u99a8","spell":"X\u012bn"},{"name":"H\u1ed2","trans":"\u6e56","spell":"H\u00fa"},{"name":"HOA","trans":"\u82b1","spell":"Hu\u0101"},{"name":"H\u00d3A","trans":"\u5316\u00a0","spell":"Hu\u00e0"},{"name":"H\u00d2A","trans":"\u548c","spell":"H\u00e9"},{"name":"H\u1eceA","trans":"\u706b","spell":"Hu\u01d2\u00a0"},{"name":"HO\u1ea0CH","trans":"\u00a0\u83b7","spell":"Hu\u00f2"},{"name":"HO\u00c0I","trans":"\u6000","spell":"Hu\u00e1i\u00a0"},{"name":"HOAN","trans":"\u6b22","spell":"Huan"},{"name":"HO\u00c1N","trans":"\u5942","spell":"Hu\u00e0n"},{"name":"HO\u00c0N","trans":"\u73af","spell":"Hu\u00e1n\u00a0"},{"name":"HO\u1ea0N","trans":"\u5ba6","spell":"Hu\u00e0n"},{"name":"HO\u00c0NG","trans":"\u9ec4","spell":"Hu\u00e1ng"},{"name":"HO\u00c0NH","trans":"\u6a2a","spell":"H\u00e9ng"},{"name":"HO\u1ea0T","trans":"\u6d3b","spell":"Hu\u00f3"},{"name":"H\u1eccC","trans":"\u5b66","spell":"Xu\u00e9\u00a0"},{"name":"H\u1ed0I","trans":"\u6094","spell":"Hu\u01d0"},{"name":"H\u1ed2I","trans":"\u56de","spell":"Hu\u00ed"},{"name":"H\u1ed8I","trans":"\u4f1a","spell":"Hu\u00ec"},{"name":"H\u1ee2I","trans":"\u4ea5","spell":"H\u00e0i\u00a0"},{"name":"H\u1ed2NG","trans":"\u7ea2","spell":"H\u00f3ng\u00a0"},{"name":"H\u1ee2P","trans":"\u5408","spell":"H\u00e9\u00a0"},{"name":"H\u1ee8A","trans":"\u8a31 (\u8bb8) ","spell":"X\u01d4"},{"name":"HU\u00c2N","trans":"\u52cb","spell":"X\u016bn\u00a0"},{"name":"HU\u1ea4N","trans":"\u8bad","spell":"Xun\u00a0"},{"name":"HU\u1ebe","trans":"\u5599","spell":"Hu\u00ec"},{"name":"HU\u1ec6","trans":"\u60e0","spell":"Hu\u00ec"},{"name":"H\u00d9NG","trans":"\u96c4","spell":"Xi\u00f3ng"},{"name":"H\u01afNG","trans":"\u5174","spell":"X\u00ecng\u00a0"},{"name":"H\u01af\u01a0NG","trans":"\u9999","spell":"Xi\u0101ng\u00a0"},{"name":"H\u01af\u1edaNG","trans":"\u5411","spell":"Xi\u00e0ng"},{"name":"H\u01af\u1edcNG","trans":"\u7ea2","spell":"H\u00f3ng"},{"name":"H\u01af\u1edeNG","trans":"\u54cd","spell":"Xi\u01ceng"},{"name":"H\u01afU","trans":"\u4f11","spell":"Xi\u016b"},{"name":"H\u1eeeU","trans":"\u53cb","spell":"You\u00a0"},{"name":"H\u1ef0U","trans":"\u53c8","spell":"Y\u00f2u"},{"name":"HUY","trans":"\u8f89","spell":"Hu\u012b\u00a0"},{"name":"HUY\u1ec0N","trans":"\u7384","spell":"Xu\u00e1n"},{"name":"HUY\u1ec6N","trans":"\u53bf","spell":"Xi\u00e0n"},{"name":"HUYNH","trans":"\u5144","spell":"Xi\u014dng\u00a0"},{"name":"HU\u1ef2NH","trans":"\u9ec4","spell":"Hu\u00e1ng"},{"name":"K\u1ebeT","trans":"\u7ed3","spell":"Ji\u00e9"},{"name":"KHA","trans":"\u8f72","spell":"K\u0113"},{"name":"KH\u1ea2","trans":"\u53ef","spell":"K\u011b"},{"name":"KH\u1ea2I","trans":"\u51ef","spell":"K\u01cei\u00a0"},{"name":"KH\u00c2M","trans":"\u94a6","spell":"Q\u012bn"},{"name":"KHANG","trans":"\u5eb7","spell":"K\u0101ng\u00a0"},{"name":"KHANH","trans":"\u537f","spell":"Q\u012bng"},{"name":"KH\u00c1NH","trans":"\u5e86","spell":"Q\u00ecng\u00a0"},{"name":"KH\u1ea8U","trans":"\u53e3","spell":"K\u01d2u"},{"name":"KHI\u00caM","trans":"\u8c26","spell":"Qi\u0101n"},{"name":"KHI\u1ebeT","trans":"\u6d01","spell":"Ji\u00e9"},{"name":"KHOA","trans":"\u79d1","spell":"K\u0113\u00a0"},{"name":"KH\u1eceE","trans":"\u597d","spell":"H\u01ceo"},{"name":"KH\u00d4I","trans":"\u9b41","spell":"Ku\u00ec\u00a0"},{"name":"KHU\u1ea4T","trans":"\u5c48","spell":"Q\u016b\u00a0"},{"name":"KHU\u00ca","trans":"\u572d","spell":"Gu\u012b\u00a0"},{"name":"KHUY\u00caN","trans":"\u5708","spell":"Qu\u0101n"},{"name":"KHUY\u1ebeN","trans":"\u529d","spell":"Qu\u00e0n"},{"name":"KI\u00caN","trans":"\u575a","spell":"Ji\u0101n"},{"name":"KI\u1ec6T","trans":"\u6770","spell":"Ji\u00e9\u00a0"},{"name":"KI\u1ec0U","trans":"\u7fd8","spell":"Qi\u00e0o\u00a0"},{"name":"KIM","trans":"\u91d1","spell":"J\u012bn"},{"name":"K\u00cdNH","trans":"\u656c","spell":"J\u00ecng"},{"name":"K\u1ef2","trans":"\u6dc7","spell":"Q\u00ed"},{"name":"K\u1ef6","trans":"\u7eaa","spell":"J\u00ec"},{"name":"L\u00c3","trans":"\u5415","spell":"L\u01da\u00a0"},{"name":"L\u1ea0C","trans":"\u4e50","spell":"L\u00e8"},{"name":"LAI","trans":"\u6765","spell":"L\u00e1i"},{"name":"L\u1ea0I","trans":"\u8d56","spell":"L\u00e0i\u00a0"},{"name":"LAM","trans":"\u84dd","spell":"L\u00e1n"},{"name":"L\u00c2M","trans":"\u6797","spell":"L\u00edn\u00a0"},{"name":"L\u00c2N","trans":"\u9e9f","spell":"L\u00edn"},{"name":"L\u0102NG","trans":"\u9675","spell":"L\u00edng"},{"name":"L\u00c0NH","trans":"\u4ee4","spell":"L\u00ecng\u00a0"},{"name":"L\u00c3NH","trans":"\u9886","spell":"L\u01d0ng"},{"name":"L\u00ca","trans":"\u9ece","spell":"L\u00ed\u00a0"},{"name":"L\u1ec4","trans":"\u793c","spell":"L\u01d0"},{"name":"L\u1ec6","trans":"\u4e3d","spell":"L\u00ec"},{"name":"LEN","trans":"\u7e3a","spell":"Li\u00e1n\u00a0"},{"name":"LI","trans":"\u729b","spell":"M\u00e1o"},{"name":"L\u1ecaCH","trans":"\u5386","spell":"L\u00ec"},{"name":"LI\u00caN","trans":"\u83b2","spell":"Li\u00e1n"},{"name":"LI\u1ec4U","trans":"\u67f3","spell":"Li\u01d4"},{"name":"LINH","trans":"\u6ce0","spell":"L\u00edng"},{"name":"LOAN","trans":"\u6e7e","spell":"W\u0101n"},{"name":"L\u1ed8C","trans":"\u7984","spell":"L\u00f9"},{"name":"L\u1ee2I","trans":"\u5229","spell":"L\u00ec"},{"name":"LONG","trans":"\u9f99","spell":"L\u00f3ng"},{"name":"L\u1ee4A","trans":"\u7ef8","spell":"Ch\u00f3u"},{"name":"LU\u00c2N","trans":"\u4f26","spell":"L\u00fan\u00a0"},{"name":"LU\u1eacN","trans":"\u8bba","spell":"L\u00f9n"},{"name":"L\u1ee4C","trans":"\u9678","spell":"L\u00f9\u00a0"},{"name":"L\u1ef0C","trans":"\u529b","spell":"L\u00ec"},{"name":"L\u01af\u01a0NG","trans":"\u826f","spell":"Li\u00e1ng"},{"name":"L\u01af\u1ee2NG","trans":"\u4eae","spell":"Li\u00e0ng"},{"name":"L\u01afU","trans":"\u5218","spell":"Li\u00fa"},{"name":"LUY\u1ebeN","trans":"\u604b","spell":"Li\u00e0n"},{"name":"LY","trans":"\u7483","spell":"L\u00ed\u00a0"},{"name":"L\u00dd","trans":"\u674e","spell":"Li\u00a0"},{"name":"M\u00c3","trans":"\u9a6c","spell":"M\u01ce\u00a0"},{"name":"MAI","trans":"\u6885","spell":"M\u00e9i\u00a0"},{"name":"M\u1eacN","trans":"\u674e","spell":"Li"},{"name":"M\u1ea0NH","trans":"\u5b5f","spell":"M\u00e8ng\u00a0"},{"name":"M\u1eacU","trans":"\u8d38","spell":"M\u00e0o"},{"name":"M\u00c2Y","trans":"\u4e91","spell":"Y\u00fan"},{"name":"M\u1ebeN","trans":"\u7f05","spell":"Mi\u01cen"},{"name":"M\u1eca","trans":"\u54aa","spell":"M\u012b"},{"name":"M\u1ecaCH","trans":"\u5e42","spell":"Mi"},{"name":"MI\u00caN","trans":"\u7ef5","spell":"Mi\u00e1n"},{"name":"MINH","trans":"\u660e","spell":"M\u00edng\u00a0"},{"name":"M\u01a0","trans":"\u68a6","spell":"M\u00e8ng"},{"name":"M\u1ed4","trans":"\u5256","spell":"P\u014du"},{"name":"MY","trans":"\u5d4b","spell":"M\u00e9i\u00a0"},{"name":"M\u1ef8","trans":"\u7f8e","spell":"M\u011bi\u00a0"},{"name":"NAM","trans":"\u5357","spell":"N\u00e1n\u00a0"},{"name":"NG\u00c2N","trans":"\u94f6","spell":"Y\u00edn"},{"name":"NG\u00c1T","trans":"\u99a5","spell":"F\u00f9"},{"name":"NGH\u1ec6","trans":"\u827a","spell":"Y\u00ec"},{"name":"NGH\u1eca","trans":"\u8bae","spell":"Y\u00ec"},{"name":"NGH\u0128A","trans":"\u4e49","spell":"Y\u00ec"},{"name":"NG\u00d4","trans":"\u5434","spell":"W\u00fa\u00a0"},{"name":"NG\u1ed8","trans":"\u609f","spell":"W\u00f9\u00a0"},{"name":"NGOAN","trans":"\u4e56","spell":"Gu\u0101i"},{"name":"NG\u1eccC","trans":"\u7389","spell":"Y\u00f9"},{"name":"NGUY\u00caN","trans":"\u539f","spell":"Yu\u00e1n\u00a0"},{"name":"NGUY\u1ec4N","trans":"\u962e","spell":"Ru\u01cen\u00a0"},{"name":"NH\u00c3","trans":"\u96c5","spell":"Y\u0101"},{"name":"NH\u00c2M","trans":"\u58ec","spell":"R\u00e9n"},{"name":"NH\u00c0N","trans":"\u95f2","spell":"Xi\u00e1n"},{"name":"NH\u00c2N","trans":"\u4eba\u00a0","spell":"R\u00e9n\u00a0"},{"name":"NH\u1ea4T","trans":"\u4e00","spell":"Y\u012b"},{"name":"NH\u1eacT","trans":"\u65e5","spell":"R\u00ec\u00a0"},{"name":"NHI","trans":"\u513f","spell":"Er\u00a0"},{"name":"NHI\u00caN","trans":"\u7136","spell":"R\u00e1n\u00a0"},{"name":"NH\u01af","trans":"\u5982","spell":"R\u00fa\u00a0"},{"name":"NHUNG","trans":"\u7ed2","spell":"R\u00f3ng"},{"name":"NH\u01af\u1ee2C","trans":"\u82e5","spell":"Ru\u00f2"},{"name":"NINH","trans":"\u5a25","spell":"\u00c9"},{"name":"N\u1eee","trans":"\u5973","spell":"N\u01da\u00a0"},{"name":"N\u01af\u01a0NG","trans":"\u5a18","spell":"Niang"},{"name":"PH\u00c1C","trans":"\u6734","spell":"P\u01d4"},{"name":"PH\u1ea0M","trans":"\u8303","spell":"F\u00e0n\u00a0"},{"name":"PHAN","trans":"\u85e9","spell":"F\u0101n"},{"name":"PH\u00c1P","trans":"\u6cd5","spell":"F\u01ce"},{"name":"PHI","trans":"\u00a0-\u83f2","spell":"F\u0113i"},{"name":"PH\u00cd","trans":"\u8d39","spell":"F\u00e8i\u00a0"},{"name":"PHONG","trans":"\u5cf0","spell":"F\u0113ng"},{"name":"PHONG","trans":"\u98ce","spell":"F\u0113ng"},{"name":"PH\u00da","trans":"\u5bcc","spell":"F\u00f9\u00a0"},{"name":"PH\u00d9","trans":"\u6276","spell":"F\u00fa\u00a0"},{"name":"PH\u00daC","trans":"\u798f","spell":"F\u00fa"},{"name":"PH\u00d9NG","trans":"\u51af","spell":"F\u00e9ng\u00a0"},{"name":"PH\u1ee4NG","trans":"\u51e4","spell":"F\u00e8ng"},{"name":"PH\u01af\u01a0NG","trans":"\u82b3","spell":"F\u0101ng\u00a0"},{"name":"PH\u01af\u1ee2NG","trans":"\u51e4","spell":"F\u00e8ng\u00a0"},{"name":"QU\u00c1CH","trans":"\u90ed","spell":"Gu\u014d\u00a0"},{"name":"QUAN","trans":"\u5173","spell":"Gu\u0101n"},{"name":"QU\u00c2N","trans":"\u519b","spell":"J\u016bn\u00a0"},{"name":"QUANG","trans":"\u5149","spell":"Gu\u0101ng"},{"name":"QU\u1ea2NG","trans":"\u5e7f","spell":"Gu\u01ceng"},{"name":"QU\u1ebe","trans":"\u6842","spell":"Gu\u00ec"},{"name":"QU\u1ed0C","trans":"\u56fd","spell":"Gu\u00f3"},{"name":"QU\u00dd","trans":"\u8d35","spell":"Gu\u00ec"},{"name":"QUY\u00caN","trans":"\u5a1f","spell":"Ju\u0101n\u00a0"},{"name":"QUY\u1ec0N","trans":"\u6743","spell":"Qu\u00e1n"},{"name":"QUY\u1ebeT","trans":"\u51b3","spell":"Ju\u00e9"},{"name":"QU\u1ef2NH","trans":"\u743c","spell":"Qi\u00f3ng"},{"name":"S\u00c2M","trans":"\u68ee","spell":"S\u0113n"},{"name":"S\u1ea8M","trans":"\u5be9","spell":"Sh\u011bn\u00a0"},{"name":"SANG","trans":"\u7027","spell":"Shu\u0101ng"},{"name":"S\u00c1NG","trans":"\u521b","spell":"Chu\u00e0ng"},{"name":"SEN","trans":"\u83b2","spell":"Li\u00e1n"},{"name":"S\u01a0N","trans":"\u5c71","spell":"Sh\u0101n"},{"name":"SONG","trans":"\u53cc","spell":"Shu\u0101ng"},{"name":"S\u01af\u01a0NG","trans":"\u971c","spell":"Shu\u0101ng"},{"name":"T\u1ea0","trans":"\u8c22","spell":"Xi\u00e8"},{"name":"T\u00c0I","trans":"\u624d","spell":"C\u00e1i\u00a0"},{"name":"T\u00c2N","trans":"\u65b0","spell":"X\u012bn\u00a0"},{"name":"T\u1ea4N","trans":"\u664b","spell":"J\u00ecn"},{"name":"T\u0102NG","trans":"\u66fe","spell":"C\u00e9ng"},{"name":"T\u00c0O","trans":"\u66f9\u00a0","spell":"C\u00e1o"},{"name":"T\u1ea0O","trans":"\u9020","spell":"Z\u00e0o"},{"name":"TH\u1ea0CH","trans":"\u77f3","spell":"Sh\u00ed"},{"name":"TH\u00c1I","trans":"\u6cf0","spell":"Zh\u014du\u00a0"},{"name":"TH\u00c1M","trans":"\u63a2","spell":"T\u00e0n"},{"name":"TH\u1eaeM","trans":"\u6df1","spell":"Sh\u0113n"},{"name":"TH\u1ea6N","trans":"\u795e","spell":"Sh\u00e9n"},{"name":"TH\u1eaeNG","trans":"\u80dc","spell":"Sh\u00e8ng\u00a0"},{"name":"THANH","trans":"\u9752","spell":"Q\u012bng\u00a0"},{"name":"TH\u00c0NH","trans":"\u57ce","spell":"Ch\u00e9ng\u00a0"},{"name":"TH\u00c0NH","trans":"\u6210","spell":"Ch\u00e9ng\u00a0"},{"name":"TH\u00c0NH","trans":"\u8bda","spell":"Ch\u00e9ng\u00a0"},{"name":"TH\u1ea0NH","trans":"\u76db","spell":"Sh\u00e8ng"},{"name":"THAO","trans":"\u6d2e","spell":"T\u00e1o"},{"name":"TH\u1ea2O","trans":"\u8349","spell":"C\u01ceo\u00a0"},{"name":"TH\u1ebe","trans":"\u4e16","spell":"Sh\u00ec\u00a0"},{"name":"TH\u1ebe","trans":"\u4e16","spell":"Sh\u00ec"},{"name":"THI","trans":"\u8bd7","spell":"Sh\u012b "},{"name":"TH\u1eca","trans":"\u6c0f","spell":"Sh\u00ec\u00a0"},{"name":"THI\u00caM","trans":"\u6dfb","spell":"Ti\u0101n\u00a0"},{"name":"THI\u00caN","trans":"\u5929","spell":"Ti\u0101n\u00a0"},{"name":"THI\u1ec0N","trans":"\u7985","spell":"Ch\u00e1n"},{"name":"THI\u1ec6N","trans":"\u5584","spell":"Sh\u00e0n\u00a0"},{"name":"THI\u1ec6U","trans":"\u7ecd","spell":"Sh\u00e0o\u00a0"},{"name":"TH\u1ecaNH","trans":"\u76db","spell":"Sh\u00e8ng\u00a0"},{"name":"THO","trans":"\u8429","spell":"Qi\u016b"},{"name":"TH\u01a0","trans":"\u8bd7","spell":"Sh\u012b"},{"name":"TH\u1ed4","trans":"\u571f","spell":"T\u01d4\u00a0"},{"name":"THOA","trans":"\u91f5","spell":"Ch\u0101i"},{"name":"THO\u1ea0I","trans":"\u8bdd","spell":"Hu\u00e0\u00a0"},{"name":"THOAN","trans":"\u7ae3","spell":"J\u00f9n"},{"name":"TH\u01a0M","trans":"\u9999","spell":"Xi\u0101ng"},{"name":"TH\u00d4NG","trans":"\u901a","spell":"T\u014dng"},{"name":"THU","trans":"\u79cb","spell":"Qi\u016b\u00a0"},{"name":"TH\u01af","trans":"\u4e66","spell":"Sh\u016b\u00a0"},{"name":"THU\u1eacN","trans":"\u987a","spell":"Sh\u00f9n\u00a0"},{"name":"TH\u1ee4C","trans":"\u719f","spell":"Sh\u00fa"},{"name":"TH\u01af\u01a0NG","trans":"\u9e27\u00a0","spell":"C\u0101ng"},{"name":"TH\u01af\u01a0NG","trans":"\u6006","spell":"Chu\u00e0ng\u00a0"},{"name":"TH\u01af\u1ee2NG","trans":"\u4e0a","spell":"Sh\u00e0ng"},{"name":"TH\u00daY","trans":"\u7fe0","spell":"Cu\u00ec"},{"name":"TH\u00d9Y","trans":"\u5782","spell":"Chu\u00ed\u00a0"},{"name":"TH\u1ee6Y","trans":"\u6c34","spell":"Shu\u01d0\u00a0"},{"name":"TH\u1ee4Y","trans":"\u745e","spell":"Ru\u00ec"},{"name":"TI\u00caN","trans":"\u4ed9","spell":"Xian\u00a0"},{"name":"TI\u1ebeN","trans":"\u8fdb","spell":"J\u00ecn\u00a0"},{"name":"TI\u1ec6P","trans":"\u6377","spell":"Ji\u00e9"},{"name":"T\u00cdN","trans":"\u4fe1","spell":"X\u00ecn\u00a0"},{"name":"T\u00ccNH","trans":"\u60c5","spell":"Q\u00edng"},{"name":"T\u1ecaNH","trans":"\u51c0","spell":"J\u00ecng\u00a0"},{"name":"T\u00d4","trans":"\u82cf","spell":"S\u016b\u00a0"},{"name":"TO\u00c0N","trans":"\u5168","spell":"Qu\u00e1n\u00a0"},{"name":"TO\u1ea2N","trans":"\u6512","spell":"Z\u01cen"},{"name":"T\u00d4N","trans":"\u5b59","spell":"S\u016bn"},{"name":"TR\u00c0","trans":"\u8336","spell":"Ch\u00e1"},{"name":"TR\u00c2M","trans":"\u7c2a","spell":"Z\u0101n\u00a0"},{"name":"TR\u1ea6M","trans":"\u6c89","spell":"Ch\u00e9n\u00a0"},{"name":"TR\u1ea6N","trans":"\u9648","spell":"Ch\u00e9n"},{"name":"TRANG","trans":"\u599d","spell":"Zhu\u0101ng\u00a0"},{"name":"TR\u00c1NG","trans":"\u58ee","spell":"Zhu\u00e0ng"},{"name":"TR\u00cd","trans":"\u667a","spell":"Zh\u00ec"},{"name":"TRI\u1ec2N","trans":"\u5c55","spell":"Zh\u01cen\u00a0"},{"name":"TRI\u1ebeT","trans":"\u54f2","spell":"Zh\u00e9"},{"name":"TRI\u1ec0U","trans":"\u671d","spell":"Ch\u00e1o"},{"name":"TRI\u1ec6U","trans":"\u8d75","spell":"Zh\u00e0o"},{"name":"TR\u1ecaNH","trans":"\u90d1","spell":"Zh\u00e8ng"},{"name":"TRINH","trans":"\u8d1e","spell":"Zh\u0113n"},{"name":"TR\u1eccNG","trans":"\u91cd","spell":"Zh\u00f2ng"},{"name":"TRUNG","trans":"\u5fe0","spell":"Zh\u014dng\u00a0"},{"name":"TR\u01af\u01a0NG","trans":"\u5f20","spell":"Zh\u0101ng\u00a0"},{"name":"T\u00da","trans":"\u5bbf","spell":"S\u00f9\u00a0"},{"name":"T\u01af","trans":"\u80e5","spell":"X\u016b"},{"name":"T\u01af","trans":"\u79c1","spell":"S\u012b"},{"name":"TU\u00c2N","trans":"\u8340","spell":"X\u00fan\u00a0"},{"name":"TU\u1ea4N","trans":"\u4fca","spell":"J\u00f9n\u00a0"},{"name":"TU\u1ec6","trans":"\u6167","spell":"Hu\u00ec"},{"name":"T\u00d9NG","trans":"\u677e","spell":"S\u014dng\u00a0"},{"name":"T\u01af\u1edcNG","trans":"\u7965","spell":"Xi\u00e1ng\u00a0"},{"name":"T\u01af\u1edeNG","trans":"\u60f3","spell":"Xi\u01ceng"},{"name":"TUY\u00caN","trans":"\u5ba3","spell":"Xu\u0101n"},{"name":"TUY\u1ec0N","trans":"\u74bf","spell":"Xu\u00e1n"},{"name":"TUY\u1ec0N","trans":"\u6cc9","spell":"Qu\u00e1n"},{"name":"TUY\u1ebeT","trans":"\u96ea","spell":"Xu\u011b\u00a0"},{"name":"T\u00dd","trans":"\u5b50","spell":"Zi"},{"name":"UY\u00caN","trans":"\u9e33\u00a0","spell":"Yu\u0101n\u00a0"},{"name":"UY\u1ec2N","trans":"\u82d1","spell":"Yu\u00e0n\u00a0"},{"name":"UY\u1ec2N","trans":"\u5a49","spell":"W\u01cen"},{"name":"V\u00c2N","trans":"\u82b8","spell":"Y\u00fan\u00a0"},{"name":"V\u0102N","trans":"\u6587","spell":"W\u00e9n\u00a0"},{"name":"V\u1ea4N","trans":"\u95ee","spell":"W\u00e8n\u00a0"},{"name":"VI","trans":"\u97e6","spell":"W\u00e9i\u00a0"},{"name":"V\u0128","trans":"\u4f1f","spell":"W\u011bi"},{"name":"VI\u1ebeT","trans":"\u66f0","spell":"Yu\u0113"},{"name":"VI\u1ec6T","trans":"\u8d8a","spell":"Yu\u00e8"},{"name":"VINH","trans":"\u8363","spell":"R\u00f3ng\u00a0"},{"name":"V\u0128NH","trans":"\u6c38","spell":"Y\u01d2ng\u00a0"},{"name":"V\u1ecaNH","trans":"\u548f","spell":"Y\u01d2ng"},{"name":"V\u00d5","trans":"\u6b66","spell":"W\u01d4"},{"name":"V\u0168","trans":"\u6b66","spell":"W\u01d4\u00a0"},{"name":"V\u0168","trans":"\u7fbd","spell":"W\u01d4\u00a0"},{"name":"V\u01af\u01a0NG","trans":"\u738b","spell":"W\u00e1ng\u00a0"},{"name":"V\u01af\u1ee2NG","trans":"\u65fa","spell":"W\u00e0ng\u00a0"},{"name":"VY","trans":"\u97e6","spell":"W\u00e9i\u00a0"},{"name":"V\u1ef8","trans":"\u4f1f","spell":"W\u011bi"},{"name":"X\u00c2M","trans":"\u6d78","spell":"J\u00ecn\u00a0"},{"name":"XU\u00c2N","trans":"\u6625","spell":"Ch\u016bn"},{"name":"XUY\u00caN","trans":"\u5ddd","spell":"Chu\u0101n"},{"name":"XUY\u1ebeN","trans":"\u4e32","spell":"Chu\u00e0n"},{"name":"\u00dd","trans":"\u610f","spell":"Y\u00ec\u00a0"},{"name":"Y\u00caN","trans":"\u5b89","spell":"\u0100n"},{"name":"Y\u1ebeN","trans":"\u71d5","spell":"Y\u00e0n\u00a0"}]';
//        $data = json_decode($json, true);
//        foreach ($data as $item) {
//            if (!($translation = NameTranslation::find()->where(['word' => $item['name']])->one())) {
//                $translation = new NameTranslation();
//            }
//            $translation->word = mb_strtolower($item['name']);
//            $translation->translated_word = $item['trans'];
//            $translation->spelling = $item['spell'];
//            $translation->status = 1;
//            echo "\nImport word = $translation->word";
//            if (!$translation->save()) {
//                echo " failed with error:\n";
//                echo var_dump($translation->getErrors()) . "\n";
//            } else {
//                echo " successfully\n";
//            }
//        }
//    }


    public function actionNameTrans() {
        $first_name_data = json_decode(file_get_contents(\Yii::getAlias('@console/data/ten-trong-truyen.json', 'r')), true);
//        $last_name_data = json_decode(file_get_contents(\Yii::getAlias('@console/data/ho-tieng-trung.json', 'r'), true));

        foreach ($first_name_data as $item) {
            $model = new \common\models\NameTranslation();
            $model->word = $item[0];
            $model->translated_word = $item[1];
            $model->spelling = $item[2];
            $model->meaning = '';
            $model->type = 1;
            $model->save();
        }

//        foreach ($last_name_data as $item) {
//            $model = new \common\models\NameTranslation();
//            $model->word = $item[0];
//            $model->translated_word = $item[1];
//            $model->spelling = $item[2];
//            $model->meaning = '';
//            $model->type = 2;
//            $model->save();
//        }


    }

    public function actionDict()
    {
        $data = json_decode(file_get_contents(\Yii::getAlias('@console/data/single_words.json', 'r'), true));
        foreach ($data as $item) {
            $model = new ChineseSingleWord();
            $model->word = $item[0];
            $model->spelling = $item[1];
            $model->spelling_vi = $item[2];
            $model->meaning = $item[3];
            $model->save();
        }
    }
}