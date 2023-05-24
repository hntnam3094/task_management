#!/usr/bin/env sh

set -e

npm run build

cd dist

git init
git add -A
dit commit - m 'New deployee'
git push -f git@github.com:pragmatic-reviews/vue-pages.git master:gh-pages

cd -
