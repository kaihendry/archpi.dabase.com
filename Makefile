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

clean:
	rm -f $(OUTFILES)
