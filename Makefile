doc:
	@mkdir -p "docs"

	@apigen \
	--source ./ \
	--destination docs/ --title ICanBoogie/Common \
	--exclude "*/tests/*" \
	--template-config /usr/share/php/data/ApiGen/templates/bootstrap/config.neon

clean:
	@rm -fR docs