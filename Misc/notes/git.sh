# config
git config --global user.name "Max Patiiuk"
git config --show-origin --list
git config --global alias.last 'log -1'  # alias `git last` to git log
git config --global alias.check '!npx tsc'  # alias `git last` to tsc


# help
man git-config  # colored full doc page
git config -h  # short help


# status
git status -s  # short summary


# .gitignore
starting with / means non recursive
endind with / means a directory
negation by starting with !
[abc].*  # a.qw b.a c.ts
[0-9]  # 1 2 3 4
a/**/z  # a/z a/b/z a/b/c/z


# diff
git diff --cached
git difftool  # vim


# rm
git rm --cached README.md  # untrack a file
git rm \*.log  # need backslash so that zsh doesn't expand the arg


# mv
git mv is the same as:
mv file1 file2
git rm file1
git add file2


# log
git log --stat  # show changed file
git log -p  # show edits
git log -2  # show the last 2 commits only
git log --pretty=oneline/short/full/fuller
# Can filter log by date, author, grep commit message or edited content
git log -- /path/to/file.ts  # show commits that changed that file
git log main  # show log for the `main` branch
git log --all # show log from all brances
git log remote/branch --not branch  # show commits that aren't on local
git diff master...origin/master  # show commits in between two branches


# commit
git commit --amend  # commit to previous commit (and change message)


# restore
git restore --shaged file.txt  # unstage a file
git restore file.txt  # undo changes to a file


# remote
git remote -v  # list remote origins
git remote add origin link  # add link as origin
git remote show origin  # show detailed into about a remote


# tag
git tag  # list tags
git tag -a v1.4 -m "my version 1.4"
git tag -a v1.2 4abc834  # tag a specific commit
git tag -d v1.2  # delete a tag


# push
git push --tags  # push tags to the remote
git push --delete v1.2  # delete v1.2 tag from the remote
git push --delete issue-53  # delete remote branch
git push dev:development  # push local `dev` to remote `development`
git push -u origin/dev  # set dev as the new remote upstream


# branch
git branch dev  # create a `dev` branch
git branch -d dev  # delete `dev` branch
git branch -vv  # list branches
git branch --merged  # list merged branches that can be deleted
git branch --all  # also list remote branches
git branch -u origin/dev  # change remote tracking branch


# renaming a branch
git branch --move old new
git push --set-upstream origin new
git push origin --delete old


# switch
git switch main  # switch to main
git switch -  # swithc to previous branch
git switch -c dev  # create and checkout `dev`
git switch -c dev --track origin/dev


# merge
git merge dev  # merge dev into current branch
# use merging only for fast-forwarding
git mergetool  # open a conflict resolution tool


# rebase
git rebase issue-53  # apply issue-53 only current branch
git rebase main issue-53  # apply issue-53 only main


# TODO:
review git tools: `git difftool --tool-help`
