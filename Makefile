INFILES = $(shell find . -name "index.mdwn")
OUTFILES = $(INFILES:.mdwn=.html)
TEMP:= $(shell mktemp -u /tmp/config.XXXXXX)

all: $(OUTFILES)

%.html: %.mdwn footer.inc header.inc
	@cat header.inc > $@
	@# First seen comment becomes page title
	@sed -n  '/<!--/{s/<!-- *//;s/ *-->//;p;q; }' $< >> $@
	@echo "</title></head><body>" >> $@
	@markdown $< >> $@
	@cat footer.inc >> $@
	@mv $@ $(TEMP)
	@anolis $(TEMP) $@
	@echo $< '→' $@
	@rm -f $(TEMP)

upload:
	aws --profile hsgpower s3 cp --acl public-read index.html s3://archpi.dabase.com/index.html

clean:
	rm -f $(OUTFILES)
