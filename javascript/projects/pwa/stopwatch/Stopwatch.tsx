'use client';

import React from 'react';
import { State, Action, generateReducer } from 'typesafe-reducer';

export function Stopwatch(): JSX.Element {
  const [state, dispatch] = React.useReducer(reducer, {}, getInitialState);
  const [updateValue, setUpdateValue] = React.useState<boolean>(false);

  React.useEffect(() => {
    if (state.type !== 'MainState') return undefined;

    const timeOut = setTimeout(
      () => setUpdateValue(!updateValue),
      MILLISECONDS -
        (Date.now() % MILLISECONDS) +
        (state.beginTime % MILLISECONDS)
    );

    return (): void => clearTimeout(timeOut);
  }, [state, updateValue]);

  return (
    <div className="flex h-screen w-screen flex-col bg-black">
      <div
        className="flex flex-1 items-center justify-center text-white"
        style={{ fontSize: '16vw' }}
      >
        {state.type === 'MainState'
          ? formatTime(Date.now() - state.beginTime, false)
          : formatTime(state.endTime - state.beginTime, true)}
      </div>
      <div className="flex flex-1">
        <button
          type="button"
          className="flex-1 border-none bg-black active:bg-neutral-300"
          onClick={(): void =>
            dispatch({ type: 'ChangeTimeAction', duration: -MILLISECONDS })
          }
          aria-label={stopwatchLocalization.rewind}
          title={stopwatchLocalization.rewind}
        />
        <button
          type="button"
          className="flex-1 border-none bg-black active:bg-neutral-300"
          onClick={(): void => dispatch({ type: 'PauseResumeAction' })}
          aria-label={stopwatchLocalization.pause}
          title={stopwatchLocalization.pause}
        />
        <button
          type="button"
          className="flex-1 border-none bg-black active:bg-neutral-300"
          onClick={(): void =>
            dispatch({ type: 'ChangeTimeAction', duration: MILLISECONDS })
          }
          aria-label={stopwatchLocalization.forward}
          title={stopwatchLocalization.forward}
        />
      </div>
      <button
        type="button"
        className="flex-1 border-none bg-black active:bg-neutral-300"
        onClick={(): void => dispatch({ type: 'StartStopAction' })}
        aria-label={stopwatchLocalization.startStop}
        title={stopwatchLocalization.startStop}
      />
    </div>
  );
}

export const stopwatchLocalization = {
  title: 'Stopwatch',
  rewind: 'Rewind',
  pause: 'Pause',
  forward: 'Forward',
  startStop: 'Start/Stop',
};

type MainState = State<
  'MainState',
  {
    beginTime: number;
  }
>;
type PausedState = State<
  'PausedState',
  {
    beginTime: number;
    endTime: number;
  }
>;
type States = MainState | PausedState;

type PauseResumeAction = Action<'PauseResumeAction'>;
type StartStopAction = Action<'StartStopAction'>;
type ChangeTime = Action<
  'ChangeTimeAction',
  {
    duration: number;
  }
>;
type Actions = PauseResumeAction | StartStopAction | ChangeTime;

const reducer = generateReducer<States, Actions>({
  PauseResumeAction: ({ state }) =>
    state.type === 'MainState'
      ? {
          type: 'PausedState',
          beginTime: state.beginTime,
          endTime: Date.now(),
        }
      : {
          type: 'MainState',
          beginTime: Date.now() - (state.endTime - state.beginTime),
        },
  StartStopAction: ({ state }) =>
    state.type === 'MainState'
      ? {
          type: 'PausedState',
          beginTime: state.beginTime,
          endTime: Date.now(),
        }
      : {
          type: 'MainState',
          beginTime: Date.now(),
        },
  ChangeTimeAction: ({ state, action }) =>
    state.type === 'MainState'
      ? {
          type: 'MainState',
          beginTime:
            state.beginTime -
            (state.beginTime - action.duration > Date.now()
              ? 0
              : action.duration),
        }
      : {
          type: 'PausedState',
          beginTime:
            state.beginTime -
            (state.endTime - (state.beginTime + action.duration) < 0
              ? 0
              : action.duration),
          endTime: state.endTime,
        },
});

const getInitialState = (): States => ({
  type: 'PausedState',
  beginTime: 0,
  endTime: 0,
});

const MINUTES = 60;
const SECONDS = 60;
const MILLISECONDS = 1000;

function formatTime(time: number, includeMilliseconds = false): string {
  const hours = Math.floor(time / MILLISECONDS / SECONDS / MINUTES);
  const minutes = Math.floor(time / MILLISECONDS / SECONDS) - hours * MINUTES;
  const seconds =
    Math.floor(time / MILLISECONDS) - hours * MINUTES - minutes * SECONDS;
  const milliseconds = time % MILLISECONDS;
  const results = [];
  if (hours > 0) results.push(hours);
  if (hours > 0 || minutes > 0) results.push(minutes);
  if (hours > 0 || minutes > 0 || seconds > 0) results.push(seconds);
  if (results.length === 0 && milliseconds === 0) return '';
  return `${results
    .map((number, index) =>
      index === 0 ? number : String(number).padStart(2, '0')
    )
    .join(':')}${includeMilliseconds ? `.${milliseconds}` : ''}`;
}
