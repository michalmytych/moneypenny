#!/bin/sh

set -e

npm install
npm run build

SHELL=/bin/sh exec npm run dev
