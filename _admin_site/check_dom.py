import urllib.request
from html.parser import HTMLParser

class FormDetector(HTMLParser):
    def __init__(self):
        super().__init__()
        self.in_form = False
        self.found_container = False

    def handle_starttag(self, tag, attrs):
        if tag == "form":
            self.in_form = True
            
        attr_dict = dict(attrs)
        if attr_dict.get('id') == "carac-prices-container":
            self.found_container = True
            print(f"Container element found! Is inside form? {self.in_form}")
            
    def handle_endtag(self, tag):
        if tag == "form":
            self.in_form = False

url = "http://localhost/shop/_admin_site/index.php?r=mproduits&id=4136"
print("Downloading URL...")
req = urllib.request.Request(url)
with urllib.request.urlopen(req) as response:
    html = response.read().decode('utf-8')
    
parser = FormDetector()
parser.feed(html)
