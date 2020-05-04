.PHONY: generate_api_client
generate_api_client:
	docker run --rm -v $(CURDIR)/src/Swagger/:/local/SwaggerClient-php/lib/ swaggerapi/swagger-codegen-cli:v2.3.0 generate -i https://api.shop-pro.jp/v1/swagger.json -l php --invoker-package "ColorMeShop\Swagger" -o /local
