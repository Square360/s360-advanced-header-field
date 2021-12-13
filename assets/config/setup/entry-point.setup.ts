import * as path from 'path';
import * as shellJs from 'shelljs';
import * as fs from 'fs';
import yargs from 'yargs';
import { kebabCase } from 's360-fundamental-toolkit';

import { PROJECT_CONFIG } from '../project.config';

const ARGV = yargs(process.argv)
              .string('name')
              .string('ext')
              .boolean('skipEntryPointCheck')
              .argv;

if (ARGV['name'] !== undefined) {
  const ARG_NAME: string = ARGV['name'];
  const ARG_EXTENSION: string = ARGV['ext'] ? ARGV['ext'] : 'js';
  const SKIP_ENTRY_POINT_CHECK: boolean = ARGV['skipEntryPointCheck'] ? ARGV['skipEntryPointCheck'] : false;

  // Use destructuring to get variables from PROJECT_CONFIG.
  const { projectName: PROJECT_NAME,
          entryPoints: ENTRY_POINTS } = PROJECT_CONFIG;

  // The name of the entry point without extension.
  const CHUNK_NAME: string = `${ kebabCase(PROJECT_NAME) }.${ kebabCase(ARG_NAME) }`;

  // The CHUNK_NAME (entry point) with extension.
  const NEW_ENTRY_POINT: string = `${ CHUNK_NAME }.${ ARG_EXTENSION }`;
  const NEW_ENTRY_POINT_STYLE: string = `${ CHUNK_NAME }.scss`;

  // Check to see if the entry point exits.
  if (!SKIP_ENTRY_POINT_CHECK) {
    // The entry point already exists.
    if (ENTRY_POINTS.indexOf(NEW_ENTRY_POINT) !== -1) {
      console.log(`Entry point: "${ NEW_ENTRY_POINT }", already exists.`);

      process.exit();
    }

    // Reserved entry point, fontawesome, force install.
    if (NEW_ENTRY_POINT.indexOf('fontawesome') !== -1) {
      shellJs.exec('yarn install:fontawesome --ignore-scripts', { silent: true });
    }
  }

  // --------------------------------------------------
  // CREATE FILES FOR NEW ENTRY POINT
  // --------------------------------------------------

  fs.appendFile(
    `${ path.resolve('src/scss') }/${ NEW_ENTRY_POINT_STYLE }`,
    '',
    (err: any) => {
      if (err) {
        process.exit();
      }

      fs.writeFile(
        `${ path.resolve('src/js') }/${ NEW_ENTRY_POINT }`,
        [
          '// Require the stlye file inside the "src/scss" folder.',
          `require('SRC_STYLES/${ NEW_ENTRY_POINT_STYLE }');`
        ].join('\n'),
        (err: any) => {
          if (err) {
            process.exit();
          }
        }
      );
    }
  );

  // --------------------------------------------------
  // ADD THE NEW ENTRY POINT TO THE PROJECT CONFIG
  // --------------------------------------------------

  ENTRY_POINTS.push(NEW_ENTRY_POINT);

  shellJs.sed(
    '-i',
    /entryPoints: \[(\r|\n)?.+(\r|\n)?\]/, [
      `entryPoints: [${ ENTRY_POINTS.map(entryPoint => "'" + entryPoint + "'").join(',') }]`
    ].join('\n'),
    path.resolve(`config/project.config.*`)
  );

  console.log(`\nEntry point: "${ NEW_ENTRY_POINT }" created!`);
  console.log('--------------------------------------------------\n');
}
