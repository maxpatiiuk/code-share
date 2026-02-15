'use client';

import React from 'react';
import { State, Action, generateReducer } from 'typesafe-reducer';

export function ShadowGame(): JSX.Element {
  const [state, dispatch] = React.useReducer(reducer, {}, getInitialState);

  // Browsers don't allow playing vibrations before the first click
  const hadInteractions = React.useRef<boolean>(false);

  React.useEffect(() => {
    if (state.vibrationDuration === 0) return;
    if (hadInteractions.current)
      window.navigator.vibrate(state.vibrationDuration);
    setTimeout(
      () =>
        dispatch({
          type: 'StopVibrationAction',
        }),
      state.vibrationDuration
    );
  }, [state.vibrationDuration]);

  React.useEffect(() => {
    dispatch({ type: 'GenerateRandomPointAction' });

    window.addEventListener('mousedown', (event) => {
      hadInteractions.current = true;
      dispatch({
        type: 'ClickAction',
        point: { x: event.x, y: event.y },
      });
    });

    window.addEventListener('resize', () =>
      dispatch({
        type: 'ResizeAction',
      })
    );
  }, []);

  return <div className="h-screen w-screen bg-black" />;
}

const winStateDuration = 1000;
const vibrationScaler = 0.7;

type Point = {
  readonly x: number;
  readonly y: number;
};

type MainState = State<
  'MainState',
  {
    point: Point;
    errorRadius: number;
    vibrationDuration: number;
  }
>;
type States = MainState;

type ClickAction = Action<'ClickAction', { point: Point }>;
type GenerateRandomPointAction = Action<'GenerateRandomPointAction'>;
type ResizeAction = Action<'ResizeAction'>;
type StopVibrationAction = Action<'StopVibrationAction'>;

type Actions =
  | ClickAction
  | ResizeAction
  | GenerateRandomPointAction
  | StopVibrationAction;

const reducer = generateReducer<States, Actions>({
  ClickAction: ({ state, action }) => {
    const distanceToPoint = Math.sqrt(
      (state.point.x - action.point.x) ** 2 +
        (state.point.y - action.point.y) ** 2
    );

    return distanceToPoint < state.errorRadius
      ? {
          ...state,
          point: getRandomPoint(),
          vibrationDuration: winStateDuration,
        }
      : {
          ...state,
          vibrationDuration: Math.max(
            state.vibrationDuration,
            Math.ceil(
              (distanceToPoint / getWindowDiagonalSize()) *
                (winStateDuration * vibrationScaler)
            )
          ),
        };
  },
  ResizeAction: ({ state }) => ({
    ...state,
    errorRadius: calculateErrorRadius(),
    point: getRandomPoint(),
  }),
  GenerateRandomPointAction: () => ({
    type: 'MainState',
    point: getRandomPoint(),
    errorRadius: calculateErrorRadius(),
    vibrationDuration: winStateDuration,
  }),
  StopVibrationAction: ({ state }) => ({
    ...state,
    vibrationDuration: 0,
  }),
});

const getRandomPoint = (): Point => ({
  x: Math.floor(Math.random() * window.innerWidth),
  y: Math.floor(Math.random() * window.innerHeight),
});

const getInitialState = (): States => ({
  type: 'MainState',
  point: { x: 0, y: 0 },
  errorRadius: 0,
  vibrationDuration: 0,
});

const errorRadiusSize = 2 ** 4;

const getWindowDiagonalSize = (): number =>
  Math.sqrt(window.innerHeight ** 2 + window.innerWidth ** 2);

const calculateErrorRadius = (): number =>
  Math.ceil(getWindowDiagonalSize() / errorRadiusSize);
