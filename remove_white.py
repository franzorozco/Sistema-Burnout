from PIL import Image

def process_mascot(input_path, output_path):
    print(f"Opening {input_path}")
    img = Image.open(input_path).convert("RGBA")
    datas = img.getdata()

    newData = []
    # Make white background transparent
    for item in datas:
        if item[0] > 230 and item[1] > 230 and item[2] > 230:
            newData.append((255, 255, 255, 0))
        else:
            newData.append(item)

    img.putdata(newData)
    
    # Crop to bounding box of non-transparent pixels
    bbox = img.getbbox()
    if bbox:
        img = img.crop(bbox)
        
    img.save(output_path, "PNG")
    print(f"Saved to {output_path}")

if __name__ == "__main__":
    process_mascot(
        r"C:\Users\Amilkar GN\.gemini\antigravity\brain\8fc9b306-382d-488b-b78c-d7a9a8769a6b\laiso_robot_pure_1779069865159.png",
        r"C:\TrabajosU\Sistema-Burnout\frontend\public\laiso_robot_final.png"
    )
