'use client';

import React from 'react';

import { SnowCrash } from '../SnowCrash';

export default function Binary(): JSX.Element {
  return (
    <SnowCrash
      colorGenerator={(): number => (Math.random() >= 0.5 ? 255 : 0)}
      monochrome
    />
  );
}
