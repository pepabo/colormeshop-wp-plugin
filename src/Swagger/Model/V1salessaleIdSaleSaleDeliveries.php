<?php
/**
 * V1salessaleIdSaleSaleDeliveries
 *
 * PHP version 5
 *
 * @category Class
 * @package  ColorMeShop\Swagger
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * カラーミーショップ API
 *
 * # カラーミーショップ API  ## 利用手順  ### OAuthアプリケーションの登録  デベロッパーアカウントをお持ちでない場合は作成します。[デベロッパー登録ページ](https://api.shop-pro.jp/developers/sign_up)から登録してください。  次に、[登録ページ](https://api.shop-pro.jp/oauth/applications/new)からアプリ登録を行ってください。 スマートフォンのWebViewを利用する場合は、リダイレクトURIに`urn:ietf:wg:oauth:2.0:oob`を入力してください。  ### 認可  カラーミーショップアカウントの認証ページを開きます。認証ページのURLは、`https://api.shop-pro.jp/oauth/authorize`に必要なパラメータをつけたものです。  |パラメータ名|値| |---|---| |`client_id`|アプリ詳細画面で確認できるクライアントID| |`response_type`|\"code\"を指定| |`scope`| 別表参照| |`redirect_uri`|アプリ登録時に入力したリダイレクトURI|  `scope`は、以下のうち、アプリが利用したい機能をスペース区切りで指定してください。  |スコープ|機能| |---|---| |`read_products`|商品データの参照| |`write_products`|在庫データの更新| |`read_sales`|受注・顧客データの参照| |`write_sales`|受注データの更新| |`read_shop_coupons`|ショップクーポンの参照|  以下のようなURLとなります。  ``` https://api.shop-pro.jp/oauth/authorize?client_id=CLIENT_ID&redirect_uri=REDIRECT_URI&response_type=code&scope=read_products%20write_products ```  初めてこのページを訪れる場合は、カラーミーショップアカウントのログインIDとパスワードの入力を求められます。  ログイン後の認証ページでアプリとの連携が承認された場合は、`code`というクエリパラメータに認可コードが付与されます。承認がキャンセルされた、またはエラーが起きた場合は、 `error`パラメータにエラーの内容を表す文字列が与えられます。  アプリ登録時のリダイレクトURIに`urn:ietf:wg:oauth:2.0:oob`を指定した場合は、以下のようなURLにリダイレクトされ、 認可コードがURLの末尾に付与されます。  ``` https://api.shop-pro.jp/oauth/authorize/AUTH_CODE ```  認可コードの有効期限は発行から10分間です。  ### 認可コードをアクセストークンに交換  以下のパラメータを付けて、`https://api.shop-pro.jp/oauth/token`へリクエストを送ります。  |パラメータ名|値| |---|---| |`client_id`|アプリ詳細画面に表示されているクライアントID| |`client_secret`|アプリ詳細画面に表示されているクライアントシークレット| |`code`|取得した認可コード| |`grant_type`|\"authorization_code\"を指定| |`redirect_uri`|アプリ登録時に入力したリダイレクトURI|  curlによるリクエストの例を以下に示します。 ```console $ curl -X POST \\   -d'client_id=CLIENT_ID' \\   -d'client_secret=CLIENT_SECRET' \\   -d'code=CODE' \\   -d'grant_type=authorization_code'   \\   -d'redirect_uri=REDIRECT_URI'  \\   'https://api.shop-pro.jp/oauth/token' ```  リクエストが成功すると、以下のようなJSONが返却されます  ```json {   \"access_token\": \"d461ab8XXXXXXXXXXXXXXXXXXXXXXXXX\",   \"token_type\": \"bearer\",   \"scope\": \"read_products write_products\" } ```  アクセストークンに有効期限はありませんが、[許可済みアプリ一覧画面](https://admin.shop-pro.jp/?mode=app_use_lst)から失効させることができます。なお、同じ認可コードをアクセストークンに交換できるのは1度だけです。  ### APIの利用  取得したアクセストークンは、Authorizationヘッダに入れて使用します。以下にショップ情報を取得する例を示します。  ```console $ curl -H 'Authorization: Bearer d461ab8XXXXXXXXXXXXXXXXXXXXXXXXX' https://api.shop-pro.jp/v1/shop.json ```  ## エラー  カラーミーショップAPIでは、以下の形式の配列でエラーを表現します。  - `code` エラーコード - `message` エラーメッセージ - `status` ステータスコード  ```json {   \"errors\": [     {       \"code\": 404100,       \"message\": \"レコードが見つかりませんでした。\",       \"status\": 404     }   ] } ```  ## 都道府県コードについて APIを利用して都道府県コードを更新したり、レスポンスを参照される際には以下の表を参考にしてください。  <details>   <summary>都道府県コード一覧</summary>    |id|都道府県|   |---|---|   |1|北海道|   |2|青森県|   |3|岩手県|   |4|秋田県|   |5|宮城県|   |6|山形県|   |7|福島県|   |8|茨城県|   |9|栃木県|   |10|群馬県|   |11|埼玉県|   |12|千葉県|   |13|東京都|   |14|神奈川県|   |15|新潟県|   |16|福井県|   |17|石川県|   |18|富山県|   |19|静岡県|   |20|山梨県|   |21|長野県|   |22|愛知県|   |23|岐阜県|   |24|三重県|   |25|和歌山県|   |26|滋賀県|   |27|奈良県|   |28|京都府|   |29|大阪府|   |30|兵庫県|   |31|岡山県|   |32|広島県|   |33|鳥取県|   |34|島根県|   |35|山口県|   |36|香川県|   |37|徳島県|   |38|愛媛県|   |39|高知県|   |40|福岡県|   |41|佐賀県|   |42|長崎県|   |43|大分県|   |44|熊本県|   |45|宮崎県|   |46|鹿児島県|   |47|沖縄県|   |48|海外|  </details>
 *
 * OpenAPI spec version: 1.0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.27
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace ColorMeShop\Swagger\Model;

use \ArrayAccess;
use \ColorMeShop\Swagger\ObjectSerializer;

/**
 * V1salessaleIdSaleSaleDeliveries Class Doc Comment
 *
 * @category Class
 * @package  ColorMeShop\Swagger
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class V1salessaleIdSaleSaleDeliveries implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'v1salessale_id_sale_sale_deliveries';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'int',
'account_id' => 'string',
'sale_id' => 'int',
'delivery_id' => 'int',
'detail_ids' => 'int[]',
'name' => 'string',
'furigana' => 'string',
'postal' => 'string',
'pref_id' => 'int',
'pref_name' => 'string',
'address1' => 'string',
'address2' => 'string',
'tel' => 'string',
'preferred_date' => 'string',
'preferred_period' => 'string',
'slip_number' => 'string',
'noshi_text' => 'string',
'noshi_charge' => 'int',
'card_name' => 'string',
'card_text' => 'string',
'card_charge' => 'int',
'wrapping_name' => 'string',
'wrapping_charge' => 'int',
'delivery_charge' => 'int',
'total_charge' => 'int',
'tracking_url' => 'string',
'memo' => 'string',
'delivered' => 'bool'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
'account_id' => null,
'sale_id' => null,
'delivery_id' => null,
'detail_ids' => null,
'name' => null,
'furigana' => null,
'postal' => null,
'pref_id' => null,
'pref_name' => null,
'address1' => null,
'address2' => null,
'tel' => null,
'preferred_date' => null,
'preferred_period' => null,
'slip_number' => null,
'noshi_text' => null,
'noshi_charge' => null,
'card_name' => null,
'card_text' => null,
'card_charge' => null,
'wrapping_name' => null,
'wrapping_charge' => null,
'delivery_charge' => null,
'total_charge' => null,
'tracking_url' => null,
'memo' => null,
'delivered' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
'account_id' => 'account_id',
'sale_id' => 'sale_id',
'delivery_id' => 'delivery_id',
'detail_ids' => 'detail_ids',
'name' => 'name',
'furigana' => 'furigana',
'postal' => 'postal',
'pref_id' => 'pref_id',
'pref_name' => 'pref_name',
'address1' => 'address1',
'address2' => 'address2',
'tel' => 'tel',
'preferred_date' => 'preferred_date',
'preferred_period' => 'preferred_period',
'slip_number' => 'slip_number',
'noshi_text' => 'noshi_text',
'noshi_charge' => 'noshi_charge',
'card_name' => 'card_name',
'card_text' => 'card_text',
'card_charge' => 'card_charge',
'wrapping_name' => 'wrapping_name',
'wrapping_charge' => 'wrapping_charge',
'delivery_charge' => 'delivery_charge',
'total_charge' => 'total_charge',
'tracking_url' => 'tracking_url',
'memo' => 'memo',
'delivered' => 'delivered'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
'account_id' => 'setAccountId',
'sale_id' => 'setSaleId',
'delivery_id' => 'setDeliveryId',
'detail_ids' => 'setDetailIds',
'name' => 'setName',
'furigana' => 'setFurigana',
'postal' => 'setPostal',
'pref_id' => 'setPrefId',
'pref_name' => 'setPrefName',
'address1' => 'setAddress1',
'address2' => 'setAddress2',
'tel' => 'setTel',
'preferred_date' => 'setPreferredDate',
'preferred_period' => 'setPreferredPeriod',
'slip_number' => 'setSlipNumber',
'noshi_text' => 'setNoshiText',
'noshi_charge' => 'setNoshiCharge',
'card_name' => 'setCardName',
'card_text' => 'setCardText',
'card_charge' => 'setCardCharge',
'wrapping_name' => 'setWrappingName',
'wrapping_charge' => 'setWrappingCharge',
'delivery_charge' => 'setDeliveryCharge',
'total_charge' => 'setTotalCharge',
'tracking_url' => 'setTrackingUrl',
'memo' => 'setMemo',
'delivered' => 'setDelivered'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
'account_id' => 'getAccountId',
'sale_id' => 'getSaleId',
'delivery_id' => 'getDeliveryId',
'detail_ids' => 'getDetailIds',
'name' => 'getName',
'furigana' => 'getFurigana',
'postal' => 'getPostal',
'pref_id' => 'getPrefId',
'pref_name' => 'getPrefName',
'address1' => 'getAddress1',
'address2' => 'getAddress2',
'tel' => 'getTel',
'preferred_date' => 'getPreferredDate',
'preferred_period' => 'getPreferredPeriod',
'slip_number' => 'getSlipNumber',
'noshi_text' => 'getNoshiText',
'noshi_charge' => 'getNoshiCharge',
'card_name' => 'getCardName',
'card_text' => 'getCardText',
'card_charge' => 'getCardCharge',
'wrapping_name' => 'getWrappingName',
'wrapping_charge' => 'getWrappingCharge',
'delivery_charge' => 'getDeliveryCharge',
'total_charge' => 'getTotalCharge',
'tracking_url' => 'getTrackingUrl',
'memo' => 'getMemo',
'delivered' => 'getDelivered'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['sale_id'] = isset($data['sale_id']) ? $data['sale_id'] : null;
        $this->container['delivery_id'] = isset($data['delivery_id']) ? $data['delivery_id'] : null;
        $this->container['detail_ids'] = isset($data['detail_ids']) ? $data['detail_ids'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['furigana'] = isset($data['furigana']) ? $data['furigana'] : null;
        $this->container['postal'] = isset($data['postal']) ? $data['postal'] : null;
        $this->container['pref_id'] = isset($data['pref_id']) ? $data['pref_id'] : null;
        $this->container['pref_name'] = isset($data['pref_name']) ? $data['pref_name'] : null;
        $this->container['address1'] = isset($data['address1']) ? $data['address1'] : null;
        $this->container['address2'] = isset($data['address2']) ? $data['address2'] : null;
        $this->container['tel'] = isset($data['tel']) ? $data['tel'] : null;
        $this->container['preferred_date'] = isset($data['preferred_date']) ? $data['preferred_date'] : null;
        $this->container['preferred_period'] = isset($data['preferred_period']) ? $data['preferred_period'] : null;
        $this->container['slip_number'] = isset($data['slip_number']) ? $data['slip_number'] : null;
        $this->container['noshi_text'] = isset($data['noshi_text']) ? $data['noshi_text'] : null;
        $this->container['noshi_charge'] = isset($data['noshi_charge']) ? $data['noshi_charge'] : null;
        $this->container['card_name'] = isset($data['card_name']) ? $data['card_name'] : null;
        $this->container['card_text'] = isset($data['card_text']) ? $data['card_text'] : null;
        $this->container['card_charge'] = isset($data['card_charge']) ? $data['card_charge'] : null;
        $this->container['wrapping_name'] = isset($data['wrapping_name']) ? $data['wrapping_name'] : null;
        $this->container['wrapping_charge'] = isset($data['wrapping_charge']) ? $data['wrapping_charge'] : null;
        $this->container['delivery_charge'] = isset($data['delivery_charge']) ? $data['delivery_charge'] : null;
        $this->container['total_charge'] = isset($data['total_charge']) ? $data['total_charge'] : null;
        $this->container['tracking_url'] = isset($data['tracking_url']) ? $data['tracking_url'] : null;
        $this->container['memo'] = isset($data['memo']) ? $data['memo'] : null;
        $this->container['delivered'] = isset($data['delivered']) ? $data['delivered'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int $id お届け先ID
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets account_id
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->container['account_id'];
    }

    /**
     * Sets account_id
     *
     * @param string $account_id ショップアカウントID
     *
     * @return $this
     */
    public function setAccountId($account_id)
    {
        $this->container['account_id'] = $account_id;

        return $this;
    }

    /**
     * Gets sale_id
     *
     * @return int
     */
    public function getSaleId()
    {
        return $this->container['sale_id'];
    }

    /**
     * Sets sale_id
     *
     * @param int $sale_id 売上ID
     *
     * @return $this
     */
    public function setSaleId($sale_id)
    {
        $this->container['sale_id'] = $sale_id;

        return $this;
    }

    /**
     * Gets delivery_id
     *
     * @return int
     */
    public function getDeliveryId()
    {
        return $this->container['delivery_id'];
    }

    /**
     * Sets delivery_id
     *
     * @param int $delivery_id 使用された配送方法ID
     *
     * @return $this
     */
    public function setDeliveryId($delivery_id)
    {
        $this->container['delivery_id'] = $delivery_id;

        return $this;
    }

    /**
     * Gets detail_ids
     *
     * @return int[]
     */
    public function getDetailIds()
    {
        return $this->container['detail_ids'];
    }

    /**
     * Sets detail_ids
     *
     * @param int[] $detail_ids この配送に含まれる受注明細IDの配列
     *
     * @return $this
     */
    public function setDetailIds($detail_ids)
    {
        $this->container['detail_ids'] = $detail_ids;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name 宛名
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets furigana
     *
     * @return string
     */
    public function getFurigana()
    {
        return $this->container['furigana'];
    }

    /**
     * Sets furigana
     *
     * @param string $furigana 宛名のフリガナ
     *
     * @return $this
     */
    public function setFurigana($furigana)
    {
        $this->container['furigana'] = $furigana;

        return $this;
    }

    /**
     * Gets postal
     *
     * @return string
     */
    public function getPostal()
    {
        return $this->container['postal'];
    }

    /**
     * Sets postal
     *
     * @param string $postal 郵便番号
     *
     * @return $this
     */
    public function setPostal($postal)
    {
        $this->container['postal'] = $postal;

        return $this;
    }

    /**
     * Gets pref_id
     *
     * @return int
     */
    public function getPrefId()
    {
        return $this->container['pref_id'];
    }

    /**
     * Sets pref_id
     *
     * @param int $pref_id 都道府県の通し番号。北海道が1、沖縄が47
     *
     * @return $this
     */
    public function setPrefId($pref_id)
    {
        $this->container['pref_id'] = $pref_id;

        return $this;
    }

    /**
     * Gets pref_name
     *
     * @return string
     */
    public function getPrefName()
    {
        return $this->container['pref_name'];
    }

    /**
     * Sets pref_name
     *
     * @param string $pref_name 都道府県名
     *
     * @return $this
     */
    public function setPrefName($pref_name)
    {
        $this->container['pref_name'] = $pref_name;

        return $this;
    }

    /**
     * Gets address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->container['address1'];
    }

    /**
     * Sets address1
     *
     * @param string $address1 住所1
     *
     * @return $this
     */
    public function setAddress1($address1)
    {
        $this->container['address1'] = $address1;

        return $this;
    }

    /**
     * Gets address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->container['address2'];
    }

    /**
     * Sets address2
     *
     * @param string $address2 住所2
     *
     * @return $this
     */
    public function setAddress2($address2)
    {
        $this->container['address2'] = $address2;

        return $this;
    }

    /**
     * Gets tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->container['tel'];
    }

    /**
     * Sets tel
     *
     * @param string $tel 電話番号
     *
     * @return $this
     */
    public function setTel($tel)
    {
        $this->container['tel'] = $tel;

        return $this;
    }

    /**
     * Gets preferred_date
     *
     * @return string
     */
    public function getPreferredDate()
    {
        return $this->container['preferred_date'];
    }

    /**
     * Sets preferred_date
     *
     * @param string $preferred_date 配送希望日
     *
     * @return $this
     */
    public function setPreferredDate($preferred_date)
    {
        $this->container['preferred_date'] = $preferred_date;

        return $this;
    }

    /**
     * Gets preferred_period
     *
     * @return string
     */
    public function getPreferredPeriod()
    {
        return $this->container['preferred_period'];
    }

    /**
     * Sets preferred_period
     *
     * @param string $preferred_period 配送希望時間帯
     *
     * @return $this
     */
    public function setPreferredPeriod($preferred_period)
    {
        $this->container['preferred_period'] = $preferred_period;

        return $this;
    }

    /**
     * Gets slip_number
     *
     * @return string
     */
    public function getSlipNumber()
    {
        return $this->container['slip_number'];
    }

    /**
     * Sets slip_number
     *
     * @param string $slip_number 配送伝票番号
     *
     * @return $this
     */
    public function setSlipNumber($slip_number)
    {
        $this->container['slip_number'] = $slip_number;

        return $this;
    }

    /**
     * Gets noshi_text
     *
     * @return string
     */
    public function getNoshiText()
    {
        return $this->container['noshi_text'];
    }

    /**
     * Sets noshi_text
     *
     * @param string $noshi_text 熨斗の文言
     *
     * @return $this
     */
    public function setNoshiText($noshi_text)
    {
        $this->container['noshi_text'] = $noshi_text;

        return $this;
    }

    /**
     * Gets noshi_charge
     *
     * @return int
     */
    public function getNoshiCharge()
    {
        return $this->container['noshi_charge'];
    }

    /**
     * Sets noshi_charge
     *
     * @param int $noshi_charge 熨斗の料金
     *
     * @return $this
     */
    public function setNoshiCharge($noshi_charge)
    {
        $this->container['noshi_charge'] = $noshi_charge;

        return $this;
    }

    /**
     * Gets card_name
     *
     * @return string
     */
    public function getCardName()
    {
        return $this->container['card_name'];
    }

    /**
     * Sets card_name
     *
     * @param string $card_name メッセージカードの表示名
     *
     * @return $this
     */
    public function setCardName($card_name)
    {
        $this->container['card_name'] = $card_name;

        return $this;
    }

    /**
     * Gets card_text
     *
     * @return string
     */
    public function getCardText()
    {
        return $this->container['card_text'];
    }

    /**
     * Sets card_text
     *
     * @param string $card_text メッセージカードのテキスト
     *
     * @return $this
     */
    public function setCardText($card_text)
    {
        $this->container['card_text'] = $card_text;

        return $this;
    }

    /**
     * Gets card_charge
     *
     * @return int
     */
    public function getCardCharge()
    {
        return $this->container['card_charge'];
    }

    /**
     * Sets card_charge
     *
     * @param int $card_charge メッセージカードの料金
     *
     * @return $this
     */
    public function setCardCharge($card_charge)
    {
        $this->container['card_charge'] = $card_charge;

        return $this;
    }

    /**
     * Gets wrapping_name
     *
     * @return string
     */
    public function getWrappingName()
    {
        return $this->container['wrapping_name'];
    }

    /**
     * Sets wrapping_name
     *
     * @param string $wrapping_name ラッピングの表示名
     *
     * @return $this
     */
    public function setWrappingName($wrapping_name)
    {
        $this->container['wrapping_name'] = $wrapping_name;

        return $this;
    }

    /**
     * Gets wrapping_charge
     *
     * @return int
     */
    public function getWrappingCharge()
    {
        return $this->container['wrapping_charge'];
    }

    /**
     * Sets wrapping_charge
     *
     * @param int $wrapping_charge ラッピングの料金
     *
     * @return $this
     */
    public function setWrappingCharge($wrapping_charge)
    {
        $this->container['wrapping_charge'] = $wrapping_charge;

        return $this;
    }

    /**
     * Gets delivery_charge
     *
     * @return int
     */
    public function getDeliveryCharge()
    {
        return $this->container['delivery_charge'];
    }

    /**
     * Sets delivery_charge
     *
     * @param int $delivery_charge 配送料
     *
     * @return $this
     */
    public function setDeliveryCharge($delivery_charge)
    {
        $this->container['delivery_charge'] = $delivery_charge;

        return $this;
    }

    /**
     * Gets total_charge
     *
     * @return int
     */
    public function getTotalCharge()
    {
        return $this->container['total_charge'];
    }

    /**
     * Sets total_charge
     *
     * @param int $total_charge 配送料・手数料の小計
     *
     * @return $this
     */
    public function setTotalCharge($total_charge)
    {
        $this->container['total_charge'] = $total_charge;

        return $this;
    }

    /**
     * Gets tracking_url
     *
     * @return string
     */
    public function getTrackingUrl()
    {
        return $this->container['tracking_url'];
    }

    /**
     * Sets tracking_url
     *
     * @param string $tracking_url 配送状況確認URL
     *
     * @return $this
     */
    public function setTrackingUrl($tracking_url)
    {
        $this->container['tracking_url'] = $tracking_url;

        return $this;
    }

    /**
     * Gets memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->container['memo'];
    }

    /**
     * Sets memo
     *
     * @param string $memo 備考
     *
     * @return $this
     */
    public function setMemo($memo)
    {
        $this->container['memo'] = $memo;

        return $this;
    }

    /**
     * Gets delivered
     *
     * @return bool
     */
    public function getDelivered()
    {
        return $this->container['delivered'];
    }

    /**
     * Sets delivered
     *
     * @param bool $delivered 発送済みであるか否か
     *
     * @return $this
     */
    public function setDelivered($delivered)
    {
        $this->container['delivered'] = $delivered;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}