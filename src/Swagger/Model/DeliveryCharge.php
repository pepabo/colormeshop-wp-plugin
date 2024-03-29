<?php
/**
 * DeliveryCharge
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
 * DeliveryCharge Class Doc Comment
 *
 * @category Class
 * @description 配送料設定の詳細。上記の&#x60;charge_free_type&#x60;や&#x60;charge_type&#x60;に基づいて、この中から配送料が決定される
 * @package  ColorMeShop\Swagger
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class DeliveryCharge implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'delivery_charge';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'delivery_id' => 'int',
'account_id' => 'string',
'charge_fixed' => 'int',
'charge_ranges_by_price' => 'int[][]',
'charge_max_price' => 'int',
'charge_ranges_by_area' => '\ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[]',
'charge_ranges_by_weight' => 'null[][]',
'charge_ranges_max_weight' => '\ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[]'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'delivery_id' => null,
'account_id' => null,
'charge_fixed' => null,
'charge_ranges_by_price' => null,
'charge_max_price' => null,
'charge_ranges_by_area' => null,
'charge_ranges_by_weight' => null,
'charge_ranges_max_weight' => null    ];

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
        'delivery_id' => 'delivery_id',
'account_id' => 'account_id',
'charge_fixed' => 'charge_fixed',
'charge_ranges_by_price' => 'charge_ranges_by_price',
'charge_max_price' => 'charge_max_price',
'charge_ranges_by_area' => 'charge_ranges_by_area',
'charge_ranges_by_weight' => 'charge_ranges_by_weight',
'charge_ranges_max_weight' => 'charge_ranges_max_weight'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'delivery_id' => 'setDeliveryId',
'account_id' => 'setAccountId',
'charge_fixed' => 'setChargeFixed',
'charge_ranges_by_price' => 'setChargeRangesByPrice',
'charge_max_price' => 'setChargeMaxPrice',
'charge_ranges_by_area' => 'setChargeRangesByArea',
'charge_ranges_by_weight' => 'setChargeRangesByWeight',
'charge_ranges_max_weight' => 'setChargeRangesMaxWeight'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'delivery_id' => 'getDeliveryId',
'account_id' => 'getAccountId',
'charge_fixed' => 'getChargeFixed',
'charge_ranges_by_price' => 'getChargeRangesByPrice',
'charge_max_price' => 'getChargeMaxPrice',
'charge_ranges_by_area' => 'getChargeRangesByArea',
'charge_ranges_by_weight' => 'getChargeRangesByWeight',
'charge_ranges_max_weight' => 'getChargeRangesMaxWeight'    ];

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
        $this->container['delivery_id'] = isset($data['delivery_id']) ? $data['delivery_id'] : null;
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['charge_fixed'] = isset($data['charge_fixed']) ? $data['charge_fixed'] : null;
        $this->container['charge_ranges_by_price'] = isset($data['charge_ranges_by_price']) ? $data['charge_ranges_by_price'] : null;
        $this->container['charge_max_price'] = isset($data['charge_max_price']) ? $data['charge_max_price'] : null;
        $this->container['charge_ranges_by_area'] = isset($data['charge_ranges_by_area']) ? $data['charge_ranges_by_area'] : null;
        $this->container['charge_ranges_by_weight'] = isset($data['charge_ranges_by_weight']) ? $data['charge_ranges_by_weight'] : null;
        $this->container['charge_ranges_max_weight'] = isset($data['charge_ranges_max_weight']) ? $data['charge_ranges_max_weight'] : null;
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
     * @param int $delivery_id 配送方法ID
     *
     * @return $this
     */
    public function setDeliveryId($delivery_id)
    {
        $this->container['delivery_id'] = $delivery_id;

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
     * Gets charge_fixed
     *
     * @return int
     */
    public function getChargeFixed()
    {
        return $this->container['charge_fixed'];
    }

    /**
     * Sets charge_fixed
     *
     * @param int $charge_fixed 配送料が固定の場合の金額
     *
     * @return $this
     */
    public function setChargeFixed($charge_fixed)
    {
        $this->container['charge_fixed'] = $charge_fixed;

        return $this;
    }

    /**
     * Gets charge_ranges_by_price
     *
     * @return int[][]
     */
    public function getChargeRangesByPrice()
    {
        return $this->container['charge_ranges_by_price'];
    }

    /**
     * Sets charge_ranges_by_price
     *
     * @param int[][] $charge_ranges_by_price 配送料が変わる決済金額の区分  `[3000, 100]`であれば、3000円以下の場合、手数料は100円であることを表す
     *
     * @return $this
     */
    public function setChargeRangesByPrice($charge_ranges_by_price)
    {
        $this->container['charge_ranges_by_price'] = $charge_ranges_by_price;

        return $this;
    }

    /**
     * Gets charge_max_price
     *
     * @return int
     */
    public function getChargeMaxPrice()
    {
        return $this->container['charge_max_price'];
    }

    /**
     * Sets charge_max_price
     *
     * @param int $charge_max_price `charge_ranges_by_price`に設定されている区分以上の金額の場合の手数料
     *
     * @return $this
     */
    public function setChargeMaxPrice($charge_max_price)
    {
        $this->container['charge_max_price'] = $charge_max_price;

        return $this;
    }

    /**
     * Gets charge_ranges_by_area
     *
     * @return \ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[]
     */
    public function getChargeRangesByArea()
    {
        return $this->container['charge_ranges_by_area'];
    }

    /**
     * Sets charge_ranges_by_area
     *
     * @param \ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[] $charge_ranges_by_area 都道府県ごとの配送料
     *
     * @return $this
     */
    public function setChargeRangesByArea($charge_ranges_by_area)
    {
        $this->container['charge_ranges_by_area'] = $charge_ranges_by_area;

        return $this;
    }

    /**
     * Gets charge_ranges_by_weight
     *
     * @return null[][]
     */
    public function getChargeRangesByWeight()
    {
        return $this->container['charge_ranges_by_weight'];
    }

    /**
     * Sets charge_ranges_by_weight
     *
     * @param null[][] $charge_ranges_by_weight 配送料が変わる重量の区分  以下の値の場合、  - 1000g未満の商品を青森県に届ける際の配送料は300円 - 3000g未満の商品を青森県に届ける際の配送料は500円  であることを表す。  ```json [   [     1000,     [       {         \"pref_id\": 2,         \"pref_name\": \"青森県\",         \"charge\": 300       }     ]   ],   [     3000,     [       {         \"pref_id\": 2,         \"pref_name\": \"青森県\",         \"charge\": 500       }     ]   ] ] ```
     *
     * @return $this
     */
    public function setChargeRangesByWeight($charge_ranges_by_weight)
    {
        $this->container['charge_ranges_by_weight'] = $charge_ranges_by_weight;

        return $this;
    }

    /**
     * Gets charge_ranges_max_weight
     *
     * @return \ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[]
     */
    public function getChargeRangesMaxWeight()
    {
        return $this->container['charge_ranges_max_weight'];
    }

    /**
     * Sets charge_ranges_max_weight
     *
     * @param \ColorMeShop\Swagger\Model\DeliveryChargeChargeRangesByArea[] $charge_ranges_max_weight `charge_ranges_by_weight`に設定されている区分以上の重量の場合の手数料
     *
     * @return $this
     */
    public function setChargeRangesMaxWeight($charge_ranges_max_weight)
    {
        $this->container['charge_ranges_max_weight'] = $charge_ranges_max_weight;

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
