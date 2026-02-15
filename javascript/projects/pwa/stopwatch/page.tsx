import { Metadata } from 'next';
import { Stopwatch, stopwatchLocalization } from './Stopwatch';

export default function Page(): JSX.Element {
  return <Stopwatch />;
}

export const metadata: Metadata = {
  title: stopwatchLocalization.title,
  manifest: '/projects/pwa/stopwatch/site.webmanifest',
  icons: {
    icon: '/projects/pwa/stopwatch/icon.png',
  },
  appleWebApp: {
    capable: true,
    statusBarStyle: 'black-translucent',
  },
};
