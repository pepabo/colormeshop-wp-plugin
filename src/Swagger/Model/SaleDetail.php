<?php
/**
 * SaleDetail
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
 * SaleDetail Class Doc Comment
 *
 * @category Class
 * @package  ColorMeShop\Swagger
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class SaleDetail implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'saleDetail';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'int',
'sale_id' => 'int',
'account_id' => 'string',
'product_id' => 'int',
'sale_delivery_id' => 'int',
'option1_value' => 'string',
'option2_value' => 'string',
'option1_index' => 'int',
'option2_index' => 'int',
'product_model_number' => 'string',
'product_name' => 'string',
'pristine_product_full_name' => 'string',
'product_cost' => 'int',
'product_image_url' => 'string',
'product_thumbnail_image_url' => 'string',
'product_mobile_image_url' => 'string',
'price' => 'int',
'price_with_tax' => 'int',
'product_num' => 'int',
'unit' => 'string',
'subtotal_price' => 'int'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
'sale_id' => null,
'account_id' => null,
'product_id' => null,
'sale_delivery_id' => null,
'option1_value' => null,
'option2_value' => null,
'option1_index' => null,
'option2_index' => null,
'product_model_number' => null,
'product_name' => null,
'pristine_product_full_name' => null,
'product_cost' => null,
'product_image_url' => null,
'product_thumbnail_image_url' => null,
'product_mobile_image_url' => null,
'price' => null,
'price_with_tax' => null,
'product_num' => null,
'unit' => null,
'subtotal_price' => null    ];

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
'sale_id' => 'sale_id',
'account_id' => 'account_id',
'product_id' => 'product_id',
'sale_delivery_id' => 'sale_delivery_id',
'option1_value' => 'option1_value',
'option2_value' => 'option2_value',
'option1_index' => 'option1_index',
'option2_index' => 'option2_index',
'product_model_number' => 'product_model_number',
'product_name' => 'product_name',
'pristine_product_full_name' => 'pristine_product_full_name',
'product_cost' => 'product_cost',
'product_image_url' => 'product_image_url',
'product_thumbnail_image_url' => 'product_thumbnail_image_url',
'product_mobile_image_url' => 'product_mobile_image_url',
'price' => 'price',
'price_with_tax' => 'price_with_tax',
'product_num' => 'product_num',
'unit' => 'unit',
'subtotal_price' => 'subtotal_price'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
'sale_id' => 'setSaleId',
'account_id' => 'setAccountId',
'product_id' => 'setProductId',
'sale_delivery_id' => 'setSaleDeliveryId',
'option1_value' => 'setOption1Value',
'option2_value' => 'setOption2Value',
'option1_index' => 'setOption1Index',
'option2_index' => 'setOption2Index',
'product_model_number' => 'setProductModelNumber',
'product_name' => 'setProductName',
'pristine_product_full_name' => 'setPristineProductFullName',
'product_cost' => 'setProductCost',
'product_image_url' => 'setProductImageUrl',
'product_thumbnail_image_url' => 'setProductThumbnailImageUrl',
'product_mobile_image_url' => 'setProductMobileImageUrl',
'price' => 'setPrice',
'price_with_tax' => 'setPriceWithTax',
'product_num' => 'setProductNum',
'unit' => 'setUnit',
'subtotal_price' => 'setSubtotalPrice'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
'sale_id' => 'getSaleId',
'account_id' => 'getAccountId',
'product_id' => 'getProductId',
'sale_delivery_id' => 'getSaleDeliveryId',
'option1_value' => 'getOption1Value',
'option2_value' => 'getOption2Value',
'option1_index' => 'getOption1Index',
'option2_index' => 'getOption2Index',
'product_model_number' => 'getProductModelNumber',
'product_name' => 'getProductName',
'pristine_product_full_name' => 'getPristineProductFullName',
'product_cost' => 'getProductCost',
'product_image_url' => 'getProductImageUrl',
'product_thumbnail_image_url' => 'getProductThumbnailImageUrl',
'product_mobile_image_url' => 'getProductMobileImageUrl',
'price' => 'getPrice',
'price_with_tax' => 'getPriceWithTax',
'product_num' => 'getProductNum',
'unit' => 'getUnit',
'subtotal_price' => 'getSubtotalPrice'    ];

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
        $this->container['sale_id'] = isset($data['sale_id']) ? $data['sale_id'] : null;
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['product_id'] = isset($data['product_id']) ? $data['product_id'] : null;
        $this->container['sale_delivery_id'] = isset($data['sale_delivery_id']) ? $data['sale_delivery_id'] : null;
        $this->container['option1_value'] = isset($data['option1_value']) ? $data['option1_value'] : null;
        $this->container['option2_value'] = isset($data['option2_value']) ? $data['option2_value'] : null;
        $this->container['option1_index'] = isset($data['option1_index']) ? $data['option1_index'] : null;
        $this->container['option2_index'] = isset($data['option2_index']) ? $data['option2_index'] : null;
        $this->container['product_model_number'] = isset($data['product_model_number']) ? $data['product_model_number'] : null;
        $this->container['product_name'] = isset($data['product_name']) ? $data['product_name'] : null;
        $this->container['pristine_product_full_name'] = isset($data['pristine_product_full_name']) ? $data['pristine_product_full_name'] : null;
        $this->container['product_cost'] = isset($data['product_cost']) ? $data['product_cost'] : null;
        $this->container['product_image_url'] = isset($data['product_image_url']) ? $data['product_image_url'] : null;
        $this->container['product_thumbnail_image_url'] = isset($data['product_thumbnail_image_url']) ? $data['product_thumbnail_image_url'] : null;
        $this->container['product_mobile_image_url'] = isset($data['product_mobile_image_url']) ? $data['product_mobile_image_url'] : null;
        $this->container['price'] = isset($data['price']) ? $data['price'] : null;
        $this->container['price_with_tax'] = isset($data['price_with_tax']) ? $data['price_with_tax'] : null;
        $this->container['product_num'] = isset($data['product_num']) ? $data['product_num'] : null;
        $this->container['unit'] = isset($data['unit']) ? $data['unit'] : null;
        $this->container['subtotal_price'] = isset($data['subtotal_price']) ? $data['subtotal_price'] : null;
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
     * @param int $id 受注明細ID
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

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
     * Gets product_id
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->container['product_id'];
    }

    /**
     * Sets product_id
     *
     * @param int $product_id 商品ID
     *
     * @return $this
     */
    public function setProductId($product_id)
    {
        $this->container['product_id'] = $product_id;

        return $this;
    }

    /**
     * Gets sale_delivery_id
     *
     * @return int
     */
    public function getSaleDeliveryId()
    {
        return $this->container['sale_delivery_id'];
    }

    /**
     * Sets sale_delivery_id
     *
     * @param int $sale_delivery_id お届け先ID
     *
     * @return $this
     */
    public function setSaleDeliveryId($sale_delivery_id)
    {
        $this->container['sale_delivery_id'] = $sale_delivery_id;

        return $this;
    }

    /**
     * Gets option1_value
     *
     * @return string
     */
    public function getOption1Value()
    {
        return $this->container['option1_value'];
    }

    /**
     * Sets option1_value
     *
     * @param string $option1_value オプション1の値(最新の商品情報)
     *
     * @return $this
     */
    public function setOption1Value($option1_value)
    {
        $this->container['option1_value'] = $option1_value;

        return $this;
    }

    /**
     * Gets option2_value
     *
     * @return string
     */
    public function getOption2Value()
    {
        return $this->container['option2_value'];
    }

    /**
     * Sets option2_value
     *
     * @param string $option2_value オプション2の値(最新の商品情報)
     *
     * @return $this
     */
    public function setOption2Value($option2_value)
    {
        $this->container['option2_value'] = $option2_value;

        return $this;
    }

    /**
     * Gets option1_index
     *
     * @return int
     */
    public function getOption1Index()
    {
        return $this->container['option1_index'];
    }

    /**
     * Sets option1_index
     *
     * @param int $option1_index オプション1の値の選択肢中の位置
     *
     * @return $this
     */
    public function setOption1Index($option1_index)
    {
        $this->container['option1_index'] = $option1_index;

        return $this;
    }

    /**
     * Gets option2_index
     *
     * @return int
     */
    public function getOption2Index()
    {
        return $this->container['option2_index'];
    }

    /**
     * Sets option2_index
     *
     * @param int $option2_index オプション2の値の選択肢中の位置
     *
     * @return $this
     */
    public function setOption2Index($option2_index)
    {
        $this->container['option2_index'] = $option2_index;

        return $this;
    }

    /**
     * Gets product_model_number
     *
     * @return string
     */
    public function getProductModelNumber()
    {
        return $this->container['product_model_number'];
    }

    /**
     * Sets product_model_number
     *
     * @param string $product_model_number 型番
     *
     * @return $this
     */
    public function setProductModelNumber($product_model_number)
    {
        $this->container['product_model_number'] = $product_model_number;

        return $this;
    }

    /**
     * Gets product_name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->container['product_name'];
    }

    /**
     * Sets product_name
     *
     * @param string $product_name 商品名(最新の商品情報)
     *
     * @return $this
     */
    public function setProductName($product_name)
    {
        $this->container['product_name'] = $product_name;

        return $this;
    }

    /**
     * Gets pristine_product_full_name
     *
     * @return string
     */
    public function getPristineProductFullName()
    {
        return $this->container['pristine_product_full_name'];
    }

    /**
     * Sets pristine_product_full_name
     *
     * @param string $pristine_product_full_name 商品名とオプション名(注文時の商品情報)
     *
     * @return $this
     */
    public function setPristineProductFullName($pristine_product_full_name)
    {
        $this->container['pristine_product_full_name'] = $pristine_product_full_name;

        return $this;
    }

    /**
     * Gets product_cost
     *
     * @return int
     */
    public function getProductCost()
    {
        return $this->container['product_cost'];
    }

    /**
     * Sets product_cost
     *
     * @param int $product_cost 商品原価
     *
     * @return $this
     */
    public function setProductCost($product_cost)
    {
        $this->container['product_cost'] = $product_cost;

        return $this;
    }

    /**
     * Gets product_image_url
     *
     * @return string
     */
    public function getProductImageUrl()
    {
        return $this->container['product_image_url'];
    }

    /**
     * Sets product_image_url
     *
     * @param string $product_image_url 商品画像URL
     *
     * @return $this
     */
    public function setProductImageUrl($product_image_url)
    {
        $this->container['product_image_url'] = $product_image_url;

        return $this;
    }

    /**
     * Gets product_thumbnail_image_url
     *
     * @return string
     */
    public function getProductThumbnailImageUrl()
    {
        return $this->container['product_thumbnail_image_url'];
    }

    /**
     * Sets product_thumbnail_image_url
     *
     * @param string $product_thumbnail_image_url サムネイル用商品画像URL
     *
     * @return $this
     */
    public function setProductThumbnailImageUrl($product_thumbnail_image_url)
    {
        $this->container['product_thumbnail_image_url'] = $product_thumbnail_image_url;

        return $this;
    }

    /**
     * Gets product_mobile_image_url
     *
     * @return string
     */
    public function getProductMobileImageUrl()
    {
        return $this->container['product_mobile_image_url'];
    }

    /**
     * Sets product_mobile_image_url
     *
     * @param string $product_mobile_image_url モバイル用商品画像URL
     *
     * @return $this
     */
    public function setProductMobileImageUrl($product_mobile_image_url)
    {
        $this->container['product_mobile_image_url'] = $product_mobile_image_url;

        return $this;
    }

    /**
     * Gets price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->container['price'];
    }

    /**
     * Sets price
     *
     * @param int $price 商品販売価格
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->container['price'] = $price;

        return $this;
    }

    /**
     * Gets price_with_tax
     *
     * @return int
     */
    public function getPriceWithTax()
    {
        return $this->container['price_with_tax'];
    }

    /**
     * Sets price_with_tax
     *
     * @param int $price_with_tax 税込み商品価格
     *
     * @return $this
     */
    public function setPriceWithTax($price_with_tax)
    {
        $this->container['price_with_tax'] = $price_with_tax;

        return $this;
    }

    /**
     * Gets product_num
     *
     * @return int
     */
    public function getProductNum()
    {
        return $this->container['product_num'];
    }

    /**
     * Sets product_num
     *
     * @param int $product_num 商品点数
     *
     * @return $this
     */
    public function setProductNum($product_num)
    {
        $this->container['product_num'] = $product_num;

        return $this;
    }

    /**
     * Gets unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->container['unit'];
    }

    /**
     * Sets unit
     *
     * @param string $unit 単位
     *
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->container['unit'] = $unit;

        return $this;
    }

    /**
     * Gets subtotal_price
     *
     * @return int
     */
    public function getSubtotalPrice()
    {
        return $this->container['subtotal_price'];
    }

    /**
     * Sets subtotal_price
     *
     * @param int $subtotal_price 商品小計。販売価格と点数の積
     *
     * @return $this
     */
    public function setSubtotalPrice($subtotal_price)
    {
        $this->container['subtotal_price'] = $subtotal_price;

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
