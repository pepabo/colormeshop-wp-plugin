<?php
/**
 * InlineResponse20012Stocks
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
 * InlineResponse20012Stocks Class Doc Comment
 *
 * @category Class
 * @package  ColorMeShop\Swagger
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class InlineResponse20012Stocks implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'inline_response_200_12_stocks';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'account_id' => 'string',
'product_id' => 'int',
'name' => 'string',
'option1_value' => 'string',
'option2_value' => 'string',
'stocks' => 'int',
'few_num' => 'int',
'model_number' => 'string',
'variant_model_number' => 'string',
'category' => '\ColorMeShop\Swagger\Model\StockCategory',
'display_state' => 'string',
'sales_price' => 'int',
'price' => 'int',
'members_price' => 'int',
'cost' => 'int',
'delivery_charge' => 'int',
'cool_charge' => 'int',
'min_num' => 'int',
'max_num' => 'int',
'sale_start_date' => 'int',
'sale_end_date' => 'int',
'unit' => 'string',
'weight' => 'int',
'soldout_display' => 'bool',
'sort' => 'int',
'simple_expl' => 'string',
'expl' => 'string',
'mobile_expl' => 'string',
'smartphone_expl' => 'string',
'make_date' => 'int',
'update_date' => 'int',
'memo' => 'string',
'image_url' => 'string',
'mobile_image_url' => 'string',
'thumbnail_image_url' => 'string',
'images' => '\ColorMeShop\Swagger\Model\StockImages[]'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'account_id' => null,
'product_id' => null,
'name' => null,
'option1_value' => null,
'option2_value' => null,
'stocks' => null,
'few_num' => null,
'model_number' => null,
'variant_model_number' => null,
'category' => null,
'display_state' => null,
'sales_price' => null,
'price' => null,
'members_price' => null,
'cost' => null,
'delivery_charge' => null,
'cool_charge' => null,
'min_num' => null,
'max_num' => null,
'sale_start_date' => null,
'sale_end_date' => null,
'unit' => null,
'weight' => null,
'soldout_display' => null,
'sort' => null,
'simple_expl' => null,
'expl' => null,
'mobile_expl' => null,
'smartphone_expl' => null,
'make_date' => null,
'update_date' => null,
'memo' => null,
'image_url' => null,
'mobile_image_url' => null,
'thumbnail_image_url' => null,
'images' => null    ];

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
        'account_id' => 'account_id',
'product_id' => 'product_id',
'name' => 'name',
'option1_value' => 'option1_value',
'option2_value' => 'option2_value',
'stocks' => 'stocks',
'few_num' => 'few_num',
'model_number' => 'model_number',
'variant_model_number' => 'variant_model_number',
'category' => 'category',
'display_state' => 'display_state',
'sales_price' => 'sales_price',
'price' => 'price',
'members_price' => 'members_price',
'cost' => 'cost',
'delivery_charge' => 'delivery_charge',
'cool_charge' => 'cool_charge',
'min_num' => 'min_num',
'max_num' => 'max_num',
'sale_start_date' => 'sale_start_date',
'sale_end_date' => 'sale_end_date',
'unit' => 'unit',
'weight' => 'weight',
'soldout_display' => 'soldout_display',
'sort' => 'sort',
'simple_expl' => 'simple_expl',
'expl' => 'expl',
'mobile_expl' => 'mobile_expl',
'smartphone_expl' => 'smartphone_expl',
'make_date' => 'make_date',
'update_date' => 'update_date',
'memo' => 'memo',
'image_url' => 'image_url',
'mobile_image_url' => 'mobile_image_url',
'thumbnail_image_url' => 'thumbnail_image_url',
'images' => 'images'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'account_id' => 'setAccountId',
'product_id' => 'setProductId',
'name' => 'setName',
'option1_value' => 'setOption1Value',
'option2_value' => 'setOption2Value',
'stocks' => 'setStocks',
'few_num' => 'setFewNum',
'model_number' => 'setModelNumber',
'variant_model_number' => 'setVariantModelNumber',
'category' => 'setCategory',
'display_state' => 'setDisplayState',
'sales_price' => 'setSalesPrice',
'price' => 'setPrice',
'members_price' => 'setMembersPrice',
'cost' => 'setCost',
'delivery_charge' => 'setDeliveryCharge',
'cool_charge' => 'setCoolCharge',
'min_num' => 'setMinNum',
'max_num' => 'setMaxNum',
'sale_start_date' => 'setSaleStartDate',
'sale_end_date' => 'setSaleEndDate',
'unit' => 'setUnit',
'weight' => 'setWeight',
'soldout_display' => 'setSoldoutDisplay',
'sort' => 'setSort',
'simple_expl' => 'setSimpleExpl',
'expl' => 'setExpl',
'mobile_expl' => 'setMobileExpl',
'smartphone_expl' => 'setSmartphoneExpl',
'make_date' => 'setMakeDate',
'update_date' => 'setUpdateDate',
'memo' => 'setMemo',
'image_url' => 'setImageUrl',
'mobile_image_url' => 'setMobileImageUrl',
'thumbnail_image_url' => 'setThumbnailImageUrl',
'images' => 'setImages'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'account_id' => 'getAccountId',
'product_id' => 'getProductId',
'name' => 'getName',
'option1_value' => 'getOption1Value',
'option2_value' => 'getOption2Value',
'stocks' => 'getStocks',
'few_num' => 'getFewNum',
'model_number' => 'getModelNumber',
'variant_model_number' => 'getVariantModelNumber',
'category' => 'getCategory',
'display_state' => 'getDisplayState',
'sales_price' => 'getSalesPrice',
'price' => 'getPrice',
'members_price' => 'getMembersPrice',
'cost' => 'getCost',
'delivery_charge' => 'getDeliveryCharge',
'cool_charge' => 'getCoolCharge',
'min_num' => 'getMinNum',
'max_num' => 'getMaxNum',
'sale_start_date' => 'getSaleStartDate',
'sale_end_date' => 'getSaleEndDate',
'unit' => 'getUnit',
'weight' => 'getWeight',
'soldout_display' => 'getSoldoutDisplay',
'sort' => 'getSort',
'simple_expl' => 'getSimpleExpl',
'expl' => 'getExpl',
'mobile_expl' => 'getMobileExpl',
'smartphone_expl' => 'getSmartphoneExpl',
'make_date' => 'getMakeDate',
'update_date' => 'getUpdateDate',
'memo' => 'getMemo',
'image_url' => 'getImageUrl',
'mobile_image_url' => 'getMobileImageUrl',
'thumbnail_image_url' => 'getThumbnailImageUrl',
'images' => 'getImages'    ];

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

    const DISPLAY_STATE_SHOWING = 'showing';
const DISPLAY_STATE_HIDDEN = 'hidden';
const DISPLAY_STATE_SHOWING_FOR_MEMBERS = 'showing_for_members';
const DISPLAY_STATE_SALE_FOR_MEMBERS = 'sale_for_members';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getDisplayStateAllowableValues()
    {
        return [
            self::DISPLAY_STATE_SHOWING,
self::DISPLAY_STATE_HIDDEN,
self::DISPLAY_STATE_SHOWING_FOR_MEMBERS,
self::DISPLAY_STATE_SALE_FOR_MEMBERS,        ];
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
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['product_id'] = isset($data['product_id']) ? $data['product_id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['option1_value'] = isset($data['option1_value']) ? $data['option1_value'] : null;
        $this->container['option2_value'] = isset($data['option2_value']) ? $data['option2_value'] : null;
        $this->container['stocks'] = isset($data['stocks']) ? $data['stocks'] : null;
        $this->container['few_num'] = isset($data['few_num']) ? $data['few_num'] : null;
        $this->container['model_number'] = isset($data['model_number']) ? $data['model_number'] : null;
        $this->container['variant_model_number'] = isset($data['variant_model_number']) ? $data['variant_model_number'] : null;
        $this->container['category'] = isset($data['category']) ? $data['category'] : null;
        $this->container['display_state'] = isset($data['display_state']) ? $data['display_state'] : null;
        $this->container['sales_price'] = isset($data['sales_price']) ? $data['sales_price'] : null;
        $this->container['price'] = isset($data['price']) ? $data['price'] : null;
        $this->container['members_price'] = isset($data['members_price']) ? $data['members_price'] : null;
        $this->container['cost'] = isset($data['cost']) ? $data['cost'] : null;
        $this->container['delivery_charge'] = isset($data['delivery_charge']) ? $data['delivery_charge'] : null;
        $this->container['cool_charge'] = isset($data['cool_charge']) ? $data['cool_charge'] : null;
        $this->container['min_num'] = isset($data['min_num']) ? $data['min_num'] : null;
        $this->container['max_num'] = isset($data['max_num']) ? $data['max_num'] : null;
        $this->container['sale_start_date'] = isset($data['sale_start_date']) ? $data['sale_start_date'] : null;
        $this->container['sale_end_date'] = isset($data['sale_end_date']) ? $data['sale_end_date'] : null;
        $this->container['unit'] = isset($data['unit']) ? $data['unit'] : null;
        $this->container['weight'] = isset($data['weight']) ? $data['weight'] : null;
        $this->container['soldout_display'] = isset($data['soldout_display']) ? $data['soldout_display'] : null;
        $this->container['sort'] = isset($data['sort']) ? $data['sort'] : null;
        $this->container['simple_expl'] = isset($data['simple_expl']) ? $data['simple_expl'] : null;
        $this->container['expl'] = isset($data['expl']) ? $data['expl'] : null;
        $this->container['mobile_expl'] = isset($data['mobile_expl']) ? $data['mobile_expl'] : null;
        $this->container['smartphone_expl'] = isset($data['smartphone_expl']) ? $data['smartphone_expl'] : null;
        $this->container['make_date'] = isset($data['make_date']) ? $data['make_date'] : null;
        $this->container['update_date'] = isset($data['update_date']) ? $data['update_date'] : null;
        $this->container['memo'] = isset($data['memo']) ? $data['memo'] : null;
        $this->container['image_url'] = isset($data['image_url']) ? $data['image_url'] : null;
        $this->container['mobile_image_url'] = isset($data['mobile_image_url']) ? $data['mobile_image_url'] : null;
        $this->container['thumbnail_image_url'] = isset($data['thumbnail_image_url']) ? $data['thumbnail_image_url'] : null;
        $this->container['images'] = isset($data['images']) ? $data['images'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getDisplayStateAllowableValues();
        if (!is_null($this->container['display_state']) && !in_array($this->container['display_state'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'display_state', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

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
     * @param string $name 商品名
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

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
     * @param string $option1_value オプション1の値
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
     * @param string $option2_value オプション2の値
     *
     * @return $this
     */
    public function setOption2Value($option2_value)
    {
        $this->container['option2_value'] = $option2_value;

        return $this;
    }

    /**
     * Gets stocks
     *
     * @return int
     */
    public function getStocks()
    {
        return $this->container['stocks'];
    }

    /**
     * Sets stocks
     *
     * @param int $stocks 在庫数
     *
     * @return $this
     */
    public function setStocks($stocks)
    {
        $this->container['stocks'] = $stocks;

        return $this;
    }

    /**
     * Gets few_num
     *
     * @return int
     */
    public function getFewNum()
    {
        return $this->container['few_num'];
    }

    /**
     * Sets few_num
     *
     * @param int $few_num 残りわずかとなる在庫数
     *
     * @return $this
     */
    public function setFewNum($few_num)
    {
        $this->container['few_num'] = $few_num;

        return $this;
    }

    /**
     * Gets model_number
     *
     * @return string
     */
    public function getModelNumber()
    {
        return $this->container['model_number'];
    }

    /**
     * Sets model_number
     *
     * @param string $model_number 型番
     *
     * @return $this
     */
    public function setModelNumber($model_number)
    {
        $this->container['model_number'] = $model_number;

        return $this;
    }

    /**
     * Gets variant_model_number
     *
     * @return string
     */
    public function getVariantModelNumber()
    {
        return $this->container['variant_model_number'];
    }

    /**
     * Sets variant_model_number
     *
     * @param string $variant_model_number オプションの型番
     *
     * @return $this
     */
    public function setVariantModelNumber($variant_model_number)
    {
        $this->container['variant_model_number'] = $variant_model_number;

        return $this;
    }

    /**
     * Gets category
     *
     * @return \ColorMeShop\Swagger\Model\StockCategory
     */
    public function getCategory()
    {
        return $this->container['category'];
    }

    /**
     * Sets category
     *
     * @param \ColorMeShop\Swagger\Model\StockCategory $category category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->container['category'] = $category;

        return $this;
    }

    /**
     * Gets display_state
     *
     * @return string
     */
    public function getDisplayState()
    {
        return $this->container['display_state'];
    }

    /**
     * Sets display_state
     *
     * @param string $display_state 掲載設定  - `showing`: 掲載状態 - `hidden`: 非掲載状態 - `showing_for_members`: 会員にのみ掲載 - `sale_for_members`: 掲載状態だが購入は会員のみ可能
     *
     * @return $this
     */
    public function setDisplayState($display_state)
    {
        $allowedValues = $this->getDisplayStateAllowableValues();
        if (!is_null($display_state) && !in_array($display_state, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'display_state', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['display_state'] = $display_state;

        return $this;
    }

    /**
     * Gets sales_price
     *
     * @return int
     */
    public function getSalesPrice()
    {
        return $this->container['sales_price'];
    }

    /**
     * Sets sales_price
     *
     * @param int $sales_price 販売価格
     *
     * @return $this
     */
    public function setSalesPrice($sales_price)
    {
        $this->container['sales_price'] = $sales_price;

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
     * @param int $price 定価
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->container['price'] = $price;

        return $this;
    }

    /**
     * Gets members_price
     *
     * @return int
     */
    public function getMembersPrice()
    {
        return $this->container['members_price'];
    }

    /**
     * Sets members_price
     *
     * @param int $members_price 会員価格
     *
     * @return $this
     */
    public function setMembersPrice($members_price)
    {
        $this->container['members_price'] = $members_price;

        return $this;
    }

    /**
     * Gets cost
     *
     * @return int
     */
    public function getCost()
    {
        return $this->container['cost'];
    }

    /**
     * Sets cost
     *
     * @param int $cost 原価
     *
     * @return $this
     */
    public function setCost($cost)
    {
        $this->container['cost'] = $cost;

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
     * @param int $delivery_charge 個別送料
     *
     * @return $this
     */
    public function setDeliveryCharge($delivery_charge)
    {
        $this->container['delivery_charge'] = $delivery_charge;

        return $this;
    }

    /**
     * Gets cool_charge
     *
     * @return int
     */
    public function getCoolCharge()
    {
        return $this->container['cool_charge'];
    }

    /**
     * Sets cool_charge
     *
     * @param int $cool_charge クール便の追加料金
     *
     * @return $this
     */
    public function setCoolCharge($cool_charge)
    {
        $this->container['cool_charge'] = $cool_charge;

        return $this;
    }

    /**
     * Gets min_num
     *
     * @return int
     */
    public function getMinNum()
    {
        return $this->container['min_num'];
    }

    /**
     * Sets min_num
     *
     * @param int $min_num 最小購入数量
     *
     * @return $this
     */
    public function setMinNum($min_num)
    {
        $this->container['min_num'] = $min_num;

        return $this;
    }

    /**
     * Gets max_num
     *
     * @return int
     */
    public function getMaxNum()
    {
        return $this->container['max_num'];
    }

    /**
     * Sets max_num
     *
     * @param int $max_num 最大購入数量
     *
     * @return $this
     */
    public function setMaxNum($max_num)
    {
        $this->container['max_num'] = $max_num;

        return $this;
    }

    /**
     * Gets sale_start_date
     *
     * @return int
     */
    public function getSaleStartDate()
    {
        return $this->container['sale_start_date'];
    }

    /**
     * Sets sale_start_date
     *
     * @param int $sale_start_date 掲載開始時刻
     *
     * @return $this
     */
    public function setSaleStartDate($sale_start_date)
    {
        $this->container['sale_start_date'] = $sale_start_date;

        return $this;
    }

    /**
     * Gets sale_end_date
     *
     * @return int
     */
    public function getSaleEndDate()
    {
        return $this->container['sale_end_date'];
    }

    /**
     * Sets sale_end_date
     *
     * @param int $sale_end_date 掲載終了時刻
     *
     * @return $this
     */
    public function setSaleEndDate($sale_end_date)
    {
        $this->container['sale_end_date'] = $sale_end_date;

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
     * Gets weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->container['weight'];
    }

    /**
     * Sets weight
     *
     * @param int $weight 重量(グラム単位)
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->container['weight'] = $weight;

        return $this;
    }

    /**
     * Gets soldout_display
     *
     * @return bool
     */
    public function getSoldoutDisplay()
    {
        return $this->container['soldout_display'];
    }

    /**
     * Sets soldout_display
     *
     * @param bool $soldout_display 売り切れているときもショップに表示するか
     *
     * @return $this
     */
    public function setSoldoutDisplay($soldout_display)
    {
        $this->container['soldout_display'] = $soldout_display;

        return $this;
    }

    /**
     * Gets sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->container['sort'];
    }

    /**
     * Sets sort
     *
     * @param int $sort 表示順
     *
     * @return $this
     */
    public function setSort($sort)
    {
        $this->container['sort'] = $sort;

        return $this;
    }

    /**
     * Gets simple_expl
     *
     * @return string
     */
    public function getSimpleExpl()
    {
        return $this->container['simple_expl'];
    }

    /**
     * Sets simple_expl
     *
     * @param string $simple_expl 簡易説明
     *
     * @return $this
     */
    public function setSimpleExpl($simple_expl)
    {
        $this->container['simple_expl'] = $simple_expl;

        return $this;
    }

    /**
     * Gets expl
     *
     * @return string
     */
    public function getExpl()
    {
        return $this->container['expl'];
    }

    /**
     * Sets expl
     *
     * @param string $expl 商品説明
     *
     * @return $this
     */
    public function setExpl($expl)
    {
        $this->container['expl'] = $expl;

        return $this;
    }

    /**
     * Gets mobile_expl
     *
     * @return string
     */
    public function getMobileExpl()
    {
        return $this->container['mobile_expl'];
    }

    /**
     * Sets mobile_expl
     *
     * @param string $mobile_expl フィーチャーフォン向けショップの商品説明
     *
     * @return $this
     */
    public function setMobileExpl($mobile_expl)
    {
        $this->container['mobile_expl'] = $mobile_expl;

        return $this;
    }

    /**
     * Gets smartphone_expl
     *
     * @return string
     */
    public function getSmartphoneExpl()
    {
        return $this->container['smartphone_expl'];
    }

    /**
     * Sets smartphone_expl
     *
     * @param string $smartphone_expl スマホ向けショップの商品説明
     *
     * @return $this
     */
    public function setSmartphoneExpl($smartphone_expl)
    {
        $this->container['smartphone_expl'] = $smartphone_expl;

        return $this;
    }

    /**
     * Gets make_date
     *
     * @return int
     */
    public function getMakeDate()
    {
        return $this->container['make_date'];
    }

    /**
     * Sets make_date
     *
     * @param int $make_date 商品作成日時
     *
     * @return $this
     */
    public function setMakeDate($make_date)
    {
        $this->container['make_date'] = $make_date;

        return $this;
    }

    /**
     * Gets update_date
     *
     * @return int
     */
    public function getUpdateDate()
    {
        return $this->container['update_date'];
    }

    /**
     * Sets update_date
     *
     * @param int $update_date 商品更新日時
     *
     * @return $this
     */
    public function setUpdateDate($update_date)
    {
        $this->container['update_date'] = $update_date;

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
     * Gets image_url
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->container['image_url'];
    }

    /**
     * Sets image_url
     *
     * @param string $image_url メインの商品画像URL
     *
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        $this->container['image_url'] = $image_url;

        return $this;
    }

    /**
     * Gets mobile_image_url
     *
     * @return string
     */
    public function getMobileImageUrl()
    {
        return $this->container['mobile_image_url'];
    }

    /**
     * Sets mobile_image_url
     *
     * @param string $mobile_image_url メインの商品画像のモバイル用URL
     *
     * @return $this
     */
    public function setMobileImageUrl($mobile_image_url)
    {
        $this->container['mobile_image_url'] = $mobile_image_url;

        return $this;
    }

    /**
     * Gets thumbnail_image_url
     *
     * @return string
     */
    public function getThumbnailImageUrl()
    {
        return $this->container['thumbnail_image_url'];
    }

    /**
     * Sets thumbnail_image_url
     *
     * @param string $thumbnail_image_url メインの商品画像のサムネイルURL
     *
     * @return $this
     */
    public function setThumbnailImageUrl($thumbnail_image_url)
    {
        $this->container['thumbnail_image_url'] = $thumbnail_image_url;

        return $this;
    }

    /**
     * Gets images
     *
     * @return \ColorMeShop\Swagger\Model\StockImages[]
     */
    public function getImages()
    {
        return $this->container['images'];
    }

    /**
     * Sets images
     *
     * @param \ColorMeShop\Swagger\Model\StockImages[] $images メインの商品画像以外の3つの画像に関する、PC用とモバイル用の画像URL
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->container['images'] = $images;

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
