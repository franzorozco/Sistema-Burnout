from rembg import remove
from PIL import Image

def remove_background(input_path, output_path):
    print(f"Removing background from {input_path}")
    input_img = Image.open(input_path)
    output_img = remove(input_img)
    output_img.save(output_path, "PNG")
    print(f"Saved to {output_path}")

if __name__ == "__main__":
    remove_background(
        "C:/TrabajosU/Sistema-Burnout/frontend/public/laiso_logo.png",
        "C:/TrabajosU/Sistema-Burnout/frontend/public/laiso_mascot_transparent.png"
    )
