import React from 'react';

import { draw } from './draw';

export function SnowCrash({
  colorGenerator,
  monochrome,
}: {
  readonly colorGenerator: () => number;
  readonly monochrome: boolean;
}): JSX.Element {
  return (
    <Canvas
      getDraw={(canvas, context) => (): void =>
        draw(
          colorGenerator,
          monochrome,
          context.createImageData(canvas.width, canvas.height),
          context
        )}
    />
  );
}

function Canvas({
  getDraw,
}: {
  readonly getDraw: (
    canvas: HTMLCanvasElement,
    context: CanvasRenderingContext2D
  ) => () => void;
}): JSX.Element {
  const canvasRef = React.useRef<HTMLCanvasElement | null>(null);
  const [draw, setDraw] = React.useState<(() => void) | undefined>(undefined);
  const [isPaused, setIsPaused] = React.useState<boolean>(false);

  React.useEffect(() => {
    if (canvasRef.current === null) return undefined;

    const canvas = canvasRef.current;
    const context = canvasRef.current.getContext('2d');

    if (canvas === null || context === null) return undefined;

    context.imageSmoothingEnabled = false;

    const handleResize = (): void => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      setDraw(() => getDraw(canvas, context));
    };
    window.addEventListener('resize', handleResize);
    handleResize();

    return (): void => {
      window.removeEventListener('resize', handleResize);
    };
  }, [canvasRef.current]);

  React.useEffect(() => {
    if (canvasRef.current === null || isPaused || typeof draw === 'undefined')
      return undefined;

    const canvas = canvasRef.current;
    const context = canvasRef.current.getContext('2d');

    if (canvas === null || context === null) return undefined;

    let destructorCalled = false;
    const step = (): void => {
      if (destructorCalled) return;
      draw();
      window.requestAnimationFrame(step);
    };
    step();

    return (): void => {
      destructorCalled = true;
    };
  }, [canvasRef.current, draw, isPaused]);

  return (
    <canvas
      ref={canvasRef}
      onClick={(): void => setIsPaused((isPaused) => !isPaused)}
    />
  );
}
