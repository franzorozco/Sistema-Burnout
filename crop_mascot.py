from PIL import Image

def crop_mascot(input_path, output_path):
    print(f"Opening {input_path}")
    img = Image.open(input_path)
    
    # Get dimensions
    width, height = img.size
    
    # Crop the bottom 25% to remove the text
    # box is (left, upper, right, lower)
    cropped_img = img.crop((0, 0, width, int(height * 0.78)))
    
    cropped_img.save(output_path, "PNG")
    print(f"Saved cropped mascot to {output_path}")

if __name__ == "__main__":
    crop_mascot(
        "C:/TrabajosU/Sistema-Burnout/frontend/public/laiso_mascot_transparent.png",
        "C:/TrabajosU/Sistema-Burnout/frontend/public/laiso_mascot_only.png"
    )
