import json
from lxml import etree 
from bs4 import BeautifulSoup

page = open("html.html", encoding="utf8")
dom = etree.HTML(str(BeautifulSoup(page.read(), features="lxml")))

osztalyokszama = len(dom.xpath('//*[@id="ASC_ID_643"]/div/div[6]/div/div[1]/div/div/span'))

for i in range(4, osztalyokszama + 4):
    sorokszama = len(dom.xpath(f'//*[@id="ASC_ID_643"]/div/div[6]/div/div[1]/div[{i}]/div[2]/div'))
    data = {}

    osztalyok = dom.xpath(f'//*[@id="ASC_ID_643"]/div/div[6]/div/div[1]/div[{i}]/div/span')
    
    for j in range(1, sorokszama + 1):
        orak = dom.xpath(f'//*[@id="ASC_ID_643"]/div/div[6]/div/div[1]/div[{i}]/div[2]/div[{j}]/div[{1}]/span')
        infok = dom.xpath(f'//*[@id="ASC_ID_643"]/div/div[6]/div/div[1]/div[{i}]/div[2]/div[{j}]/div[{2}]/span')

        if "\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t" in infok[0].text: data[orak[0].text] = infok[0].text.replace("\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t", " ")
    
    with open("output.json", encoding="utf-8") as f:
        dataJson = json.load(f)
        dataJson['osztalyok'][osztalyok[0].text] = data
        json.dump(dataJson, open("output.json", "w", encoding="utf-8"), indent=4, ensure_ascii=False)