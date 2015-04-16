INFILES = $(shell find . -name "index.mdwn")
OUTFILES = $(INFILES:.mdwn=.html)
TEMP:= $(shell mktemp -u /tmp/config.XXXXXX)

all: $(OUTFILES)

%.html: %.mdwn footer.inc header.inc
	@cat header.inc > $@
	@# First seen comment becomes page title
	@sed -n  '/<!--/{s/<!-- *//;s/ *-->//;p;q; }' $< >> $@
	@git describe --always >> $@
	@echo "</title></head><body><div class=container>" >> $@
	@cmark $< >> $@
	@cat footer.inc >> $@
	@mv $@ $(TEMP)
	@anolis $(TEMP) $@
	@echo $< '→' $@
	@rm -f $(TEMP)

upload:
	aws --profile hsgpower s3 sync --delete --acl public-read . s3://archpi.dabase.com/

clean:
	rm -f $(OUTFILES)
