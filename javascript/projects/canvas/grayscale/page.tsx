'use client';

import React from 'react';

import { SnowCrash } from '../SnowCrash';

export default function Grayscale(): JSX.Element {
  return (
    <SnowCrash
      colorGenerator={(): number => Math.floor(Math.random() * 256)}
      monochrome
    />
  );
}
