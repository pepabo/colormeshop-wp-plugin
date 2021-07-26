.DEFAULT_GOAL := colormeshop-wp-plugin.zip

.PHONY: generate_api_client
generate_api_client:
	docker run --rm -v $(CURDIR)/src/Swagger/:/local/SwaggerClient-php/lib/ swaggerapi/swagger-codegen-cli-v3:3.0.27 generate -i https://api.shop-pro.jp/v1/swagger.json -l php --invoker-package "ColorMeShop\Swagger" -o /local

.PHONY: build_builder_container
build_builder_container:
	docker build . -f Dockerfile.build -t colormeshop-wp-plugin-builder

colormeshop-wp-plugin.zip: build_builder_container
	docker run --rm -v $(CURDIR):/tmp/dist colormeshop-wp-plugin-builder
