import { Metadata } from 'next';
import { ShadowGame } from './ShadowGame';

export default function ProjectPage(): JSX.Element {
  return <ShadowGame />;
}

export const metadata: Metadata = {
  title: 'Shadow Game',
  manifest: '/projects/pwa/shadow-game/site.webmanifest',
  icons: {
    icon: '/projects/pwa/shadow-game/icon.png',
  },
  appleWebApp: {
    capable: true,
    statusBarStyle: 'black-translucent',
  },
};
