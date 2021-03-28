import React                  from 'react';
import { AvailableLanguages } from '../lib/languages';

export default React.createContext<AvailableLanguages['type']>('en-US');