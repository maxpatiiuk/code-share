import os 
import sys
import subprocess
import webbrowser
from pathlib import Path


git_command = "git"
search_directory = os.getcwd()
git_folder = None
report_failed_autocomplete = True

arguments = {
    parameter:value
    for parameter,value in zip(sys.argv, sys.argv[1:])
    if parameter.startswith('-')
}


while True:

    git_folder = os.path.join(search_directory, ".git/")

    if os.path.isdir(git_folder):
        break

    if str(search_directory) == '/':
        print("Not a git repository")
        exit(-1)

    search_directory = Path(search_directory).parent.absolute()


refs_folder = os.path.join(git_folder, 'refs/remotes/')


if not os.path.isdir(refs_folder):
    print("No remote is set for this repository")
    exit(-1)

remotes = [
    item for item in os.listdir(refs_folder)
    if os.path.isdir(os.path.join(refs_folder, item))
]

if len(remotes) == 0:
    print("No remote is set for this repository")
    exit(-1)

if '-r' in arguments:
    if arguments['-r'] not in remotes:
        print("Invalid remote specified")
        exit(-1)
    prefered_remote = arguments['-r']
elif "origin" in remotes:
    prefered_remote = "origin"
else:
    print("Using %s as a remote" % remotes[0])
    prefered_remote = remotes[0]


origin_url = subprocess.check_output([
    git_command,
    "config",
    "--get",
    "remote.%s.url" % prefered_remote
]).strip().decode("utf-8")

if origin_url.endswith('.git'):
    origin_url = origin_url[:-len('.git')]

if not origin_url:
    print("Unable to get origin url")
    exit(-1)


origin_folder = os.path.join(refs_folder, prefered_remote)

branches = [
    item for item in os.listdir(origin_folder)
    if item != 'HEAD'
]

if '-b' in arguments:
    prefered_branch = arguments['-b']
    endswith = prefered_branch.startswith('.')
    startswith = prefered_branch.endswith('.')
    if startswith or endswith:
        matched_branches = [
            branch for branch in branches
            if (
                (
                    not startswith or
                    branch.startswith(prefered_branch[:-1])
                ) and
                (
                    not endswith or
                    branch.endswith(prefered_branch[1:])
                )
            )
        ]
        if len(matched_branches) == 1:
            prefered_branch = matched_branches[0]
        elif len(matched_branches) > 1:
            print("Matched multiple branches: %s" % matched_branches)
            exit(0)
        elif report_failed_autocomplete:
            print("No branches matched")
            exit(0)
else:
    prefered_branch = subprocess.check_output([
        "git",
        "branch",
        "--show-current"
    ]).strip().decode("utf-8")

    if not prefered_branch:

        if len(branches) == 0:
            print("No branches found for this repository")
            exit(-1)

        elif "master" in remotes:
            prefered_branch = "master"
        elif "main" in remotes:
            prefered_branch = "main"
        else:
            print("Using %s as a branch" % branches[0])
            prefered_branch = branches[0]

relative_path = os.getcwd()[len(str(search_directory))+1:]
get_url = lambda file_name: \
    os.path.join(
        origin_url,
        "blob" if file_name
        else "tree",
        prefered_branch,
        relative_path,
        file_name
    )

if '-f' in arguments:
    url = get_url(arguments['-f'])
else:
    url = get_url('')

print("Opening %s" % url)
webbrowser.open_new_tab(url)

