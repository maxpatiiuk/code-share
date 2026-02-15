export function draw(
  colorGenerator: () => number,
  monochrome: boolean,
  imageData: ImageData,
  context: CanvasRenderingContext2D
): void {
  for (let i = 0; i < imageData.data.length; i += 4) {
    const color = colorGenerator();
    imageData.data[i] = color;
    imageData.data[i + 1] = monochrome ? color : colorGenerator();
    imageData.data[i + 2] = monochrome ? color : colorGenerator();
    imageData.data[i + 3] = 255;
  }

  context.putImageData(imageData, 0, 0);
}
