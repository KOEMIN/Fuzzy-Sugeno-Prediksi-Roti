import fitz

def extract_text(pdf_path):
    doc = fitz.open(pdf_path)
    text = ""
    for page in doc:
        text += page.get_text()
    return text

if __name__ == "__main__":
    text = extract_text("barekeng_2015_9_2_6.pdf")
    with open("pdf_text.txt", "w", encoding="utf-8") as f:
        f.write(text)
    print("Text extracted to pdf_text.txt")
