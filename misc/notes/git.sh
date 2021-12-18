# config
git config --global user.name "Max Patiiuk"
git config --show-origin --list
git config --global alias.last 'log -1'  # alias `git last` to git log
git config --global alias.check '!npx tsc'  # alias `git check` to tsc
git config --local remote.pushDefault origin  # default remote


# help
man git-config  # colored full doc page
git config -h  # short help


# status
git status -s  # short summary


# .gitignore
# starting with / means non recursive
# ending with / means a directory
# negation by starting with !
[abc].*  # a.qw b.a c.ts
[0-9]  # 1 2 3 4
a/**/z  # a/z a/b/z a/b/c/z


# diff
git diff --cached
git difftool  # vim
git diff master...origin/master  # show xor'ed commits


# rm
git rm --cached README.md  # untrack a file
git rm \*.log  # need backslash so that zsh doesn't expand the arg


# git mv is the same as:
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
git log --all  # show log from all brances
git log remote/branch --not branch  # show commits that aren't on local
git log -S mappings_path  # 'Pickaxe' # show commits that change the #
#                           of occurrences of that string
git log -L :functionName:file.name  # show changes to a function
git log -g  # shows HEAD's history


# commit
git commit --amend  # commit to previous commit (and change message)


# restore
git restore --staged file.txt  # unstage a file
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
git push origin --delete v1.2  # delete v1.2 tag from the remote
git push origin --delete issue-53  # delete remote branch
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
git switch -  # switch to previous branch
git switch -c dev  # create and checkout `dev`
git switch -c dev --track origin/dev


# checkout
git checkout HEAD~2 README.md  # revert README.md to the older one
git checkout README.md  # revert README.md from the index
git checkout --conflict=diff3 file.ts  # show 3 way conflict diff
git checkout --theirs file.ts  # --ours  # checkout one side of a merge
# conflict


# merge
git merge dev  # merge dev into current branch
# use merging only for fast-forwarding
git mergetool  # open a conflict resolution tool


# rebase
git rebase issue-53  # apply issue-53 onto current branch
git rebase main issue-53  # apply issue-53 onto main
git rebase -i HEAD~3  # launch interactive history rewriter
# rebase every commit:
git rebase -i --root `git rev-list --max-parents=0 HEAD`



# reset
git reset --soft HEAD~1  # uncommit
git reset HEAD~1 file.md  # unstage  # defaults to --mixed
git reset --hard HEAD~1  # delete

# describe
git describe --all  # creata a desciption for the current git's state


# interactive add
git add -i


# stash
git stash apply stash@{2}
git stash drop
git stash branch new-branch


# revert
git revert -m 1 HEAD  # create a revert commit for last commit


# blame
git blame -L 69,82 file.ts


# bisect
git bisect start
git bisect bad
git bisect good v1.0

git bisect start HEAD v.10
git bisect run test-error.sh  # the coolest feature ever!
# can bisect by regex and function names too

# show file from a different branch
git show branch:file
git show hash  # show info about a commit


# submodule
# allows to nest git repositories and merge upstream


# TODO:
review git tools: `git difftool --tool-help` and `mergetool`
